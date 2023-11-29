<?php
namespace framework;;

use PDO;
use Exception;

use framework\interface\InterfaceORM;

class ORM implements InterfaceORM
{
    // PDO database connection
    public $db;

    // Constructor to set up the database connection
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function find($table, $column, $val, $selectedColumns = [])
{
    try {
        // Ensure $selectedColumns is an array
        if (!is_array($selectedColumns)) {
            $selectedColumns = [$selectedColumns];
        }

        $columns = empty($selectedColumns) ? '*' : implode(', ', $selectedColumns);

        $query = "SELECT $columns FROM `$table` WHERE `$column` = :val";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':val', $val);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null; // No results
        }

        // Check for multiple rows if needed
        $additionalRows = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($additionalRows)) {
            // Handle multiple results (you can throw an exception or log a warning)
            // For now, let's just log a warning
            error_log('Warning: Multiple rows found for query.');
        }

        return $result;

    } catch (Exception $e) {
        // Handle the exception, log it, or rethrow it if needed
        throw new Exception("Error while fetching record: " . $e->getMessage());
    }
}

    
    // Get all records in the table
    public function all($table)
    {
        try {
            $query = "SELECT * FROM `$table`";
            $statement = $this->db->query($query);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Handle the exception, log it, or rethrow it if needed
            throw new Exception("Error while fetching all records: " . $e->getMessage());
        }
    }

    // Insert a new record
    public function create($table, array $data)
    {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));

            $query = "INSERT INTO `$table` ($columns) VALUES ($values)";
            $statement = $this->db->prepare($query);

            foreach ($data as $key => $value) {
                $statement->bindValue(":$key", $value);
            }   
            return $statement->execute();
        } catch (Exception $e) {
            // Handle the exception, log it, or rethrow it if needed
            throw new Exception("Error while inserting record: " . $e->getMessage());
        }
    }

    // Update a record 
    public function update($table, $column, $val, array $data)
    {
        try {
            $setClause = implode(', ', array_map(function ($column) {
                return "$column = :$column";
            }, array_keys($data)));

            $query = "UPDATE `$table` SET $setClause WHERE `$column` = :val";
            $statement = $this->db->prepare($query);

            $statement->bindParam(':val', $val);

            foreach ($data as $key => $value) {
                $statement->bindValue(":$key", $value);
            }

            return $statement->execute();
        } catch (Exception $e) {
            // Handle the exception, log it, or rethrow it if needed
            throw new Exception("Error while updating record: " . $e->getMessage());
        }
    }

    // Delete a record
    public function delete($table, $column, $val)
    {
        try {
            $query = "DELETE FROM `$table` WHERE `$column` = :val";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':val', $val);

            return $statement->execute();
        } catch (Exception $e) {
            // Handle the exception, log it, or rethrow it if needed
            throw new Exception("Error while deleting record: " . $e->getMessage());
        }
    }

    // Count the number of records in a table
    public function count($table)
    {
        try {
            $query = "SELECT COUNT(*) FROM `$table`";
            $statement = $this->db->query($query);

            return $statement->fetchColumn();
        } catch (Exception $e) {
            // Handle the exception, log it, or rethrow it if needed
            throw new Exception("Error while counting records: " . $e->getMessage());
        }
    }
}

<?php

namespace framework\interface;

use PDO;

interface InterfaceORM
{
    public function __construct(PDO $db);

    public function find($table,$column,$pk);

    public function all($table);

    public function create($table,array $data);

    public function update($table, $column, $pk, array $data);

    public function delete($table, $column, $pk);

    public function count($table);
}

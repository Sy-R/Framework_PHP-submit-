<?php
namespace web;

use app\controllers\Security;
use framework\Validator;
use framework\ORM;
use app\controllers\ErrorHandler;
use PDO;

class CreateUserValidationController
{
    
    public function create($username, $email, $password, $role)
    {
    
        //validation
        $rules = [
            'username' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ];

        $validationErrors = Validator::validate(['username' => $username, 'email' => $email, 'password' => $password], $rules);

        if(!empty($validationErrors)){
            if($validationErrors > 1)
            return ['error' => 'All fields required.'];
        }

        $rules1 = [
            'email' => ['email'],
        ];

        $error = Validator::validate(['email' => $email], $rules1);
        if(!empty($error)){
            return $error;
        }

        if (!Validator::containsDigit($password))
        {
            return ['error' => 'Password must contain a digit'];
    
        }

        if (!Validator::containsUppercase($password))
        {
            return ['error' => 'Password must contain an uppercase letter'];
        }

        if(Validator::validateLength($password,10, null)){
            return ['error' => 'Password must be at least 10 characters long'];
        }

        //Database setup
        $dbHost = "localhost";
        $dbName = "user_management_system";
        $dbUser = "root";
        $dbPassword = "";
        // create a PDO instance for the database
        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);

        //set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //create a new ORM and session instance
        $orm = new ORM($db);
        
        try{
        //Ensure username is unique - more validation
        $user = $orm->find('users','username', $username, 'username');
        if($user)
        {
        return ['error' => 'Username already exists'];
        }

        //create user in the database
        //hash password first
        $hashedPassword = Security::hashPassword($password);
        $userData = [
                'username' => $username,
                'password' => $hashedPassword,
                'email' => $email,
                'role' => $role,
            ];
        $user = $orm->create('users', $userData);

        if($user)
        {
            return ['error' => 'User Successfully Created!'];
        }else
        {
            return ['error' => 'Failed to create user'];
        }
    }catch(\Throwable $e){
        $exception = ErrorHandler::handleExceptions($e);
        ErrorHandler::logError($exception);
        return ['error' =>  $e->getMessage()];
    }
    }
}

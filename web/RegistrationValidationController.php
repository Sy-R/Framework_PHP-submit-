<?php
namespace web;

use app\controllers\Security;
use framework\Validator;
use framework\ORM;
use app\controllers\ErrorHandler;

use PDO;

class RegistrationValidationController
{
    public function register($username, $email, $password, $role)
    {
        //validation
        $rules = [
            'username' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ];

        $errors = Validator::validate(['username' => $username, 'email' => $email, 'password' => $password], $rules);

        if(!empty($errors)){
            if($errors > 1)
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

        //Add user to the database
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
         //Redirect to login page
         header('Location: Login.php');
         exit();
        }
        }catch(\Throwable $e){
            $exception = ErrorHandler::handleExceptions($e);
            ErrorHandler::logError($exception);
            return ['error' =>  $e->getMessage()];
        }
    }
   

}
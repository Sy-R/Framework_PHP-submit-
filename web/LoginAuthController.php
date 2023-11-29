<?php
namespace web;

use app\controllers\Authentication;
use app\controllers\Security;
use framework\Validator;
use framework\ORM;
use framework\Session;
use app\controllers\ErrorHandler;

use PDO;

class LoginAuthController
{
    public function login($email, $password)
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];

        $errors = Validator::validate(['email' => $email, 'password' => $password], $rules);

        if(!empty($errors)){
            return $errors;
        }

        $dbHost = "localhost";
        $dbName = "user_management_system";
        $dbUser = "root";
        $dbPassword = "";

        //create a PDO instance for the database
        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);

        //set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //create a new ORM and session instance
        $orm = new ORM($db);
        $sess = Session::getInstance();
        try{
        //find user in the database
        $user = $orm->find('users','email', $email);
        if($user){
            //verify entered password againt hashed password in the database
            $hashedPassword = $user['password'];
            if(Authentication::verifyPassword($password, $hashedPassword)){
                if($sess->sessionStatus()){
                    //set session variables
                    $sess->set('username', $user['username']);
                    $sess->set('email', $user['email']);
                    $sess->set('role', $user['role']);
                    $sess->set('id', $user['id']);
                    

                    //Generate and set csfr token
                    $csfrToken = Security::generateCSRFToken();
                    $sess->set('csfrToken', $csfrToken);

                    //Redirect to respective dashboards 
                    // header('Location: Dashboard.php?token=' . $csfrToken);
                    //RGM Dashboard
                    if($sess->getSession('role') == 'Research Group Manager')
                    {
                        header('Location: RGMDashboard.php');
                        exit();
                    }

                    //RSM Dashboard
                    if($sess->getSession('role') == 'Research Study Manager')
                    {
                        header('Location: RSMDashboard.php');
                        exit();
                    }

                    //Researcher Dashboard
                    if($sess->getSession('role') == 'Researcher')
                    {
                        header('Location: RDashboard.php');
                        exit();
                    }
                    }else 
                    {//session not started
                    ErrorHandler::logError('Failed to start session', ['email' => $email]);
                    return ['error' => 'Failed to start session'];
                    }
                }else
                {//password mismatch
                return ['error' => 'Invalid email/password.'];
                // return ['error' => 'Invalid passsword.'];
                }
            }else
            {//user not found
            return ['error' => 'Invalid email/password.'];
            }
        }catch(\Throwable $e){
            //Handle exception
            $exception = ErrorHandler::handleExceptions($e);
            ErrorHandler::logError($exception);
            return ['error' => $e->getMessage()];
        }
    }
    }

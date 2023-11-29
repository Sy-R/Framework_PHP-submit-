<?php
namespace web;

use app\views\TemplateEngine;
use app\controllers\Response;
use app\views\FormGenerator;

class LoginResponse
{
    public function index() {

        $error = '';
        //check for form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Retrieve user input data
            $email = $_POST['email'];
            $password = $_POST['password'];

            //Create an instance of userAuthController
            $loginAuth = new LoginAuthController();

            //call the login method and get the results
            $result = $loginAuth->login($email, $password);

            //Get any errors
            if(!empty($result)){
                $error = reset($result);
                //handle error
            }
        }

        //Start buffer pass header and footer for later display.
        ob_start();
        ?>
        <header> 
             <a href="Logout.php">Log out</a>
         </header>

         <footer class="footer">
             <p>Copyright &copy; Nusaybah Rahman. All Rights Reserved</p>
         </footer> 
         <?php
         $xtra['data'] = ob_get_clean();

        // Form data to be passed to the template
        $fields = [
            [
                'type' => 'paragraph',
                'id' => 'errors',
                'content' => $error,
            ],

            [
                'type' => 'heading3',
                'content' => 'Sign In',
            ],

            [
                'label' => 'Email',
                'type' => 'text',
                'id' => 'email',
                'name' => 'email',
            ],

            [
                'label' => 'Password',
                'type' => 'text',
                'id' => 'password',
                'name' => 'password',
            ],

            [
                'type' =>'submit',
                'class' =>'cntrButton',
                'value' => 'Sign in',
            ],

            [
                'type' => 'paralink',
                'label' => 'Need an account?',
                'url' => 'Registration.php',
                'value' => 'Register',
            ],
            ];

        $form = FormGenerator::generateForm('Login.php','post', $fields);

        //Template placeholders information
        $data = [
            'css' => './css/Asn1Styles.css',
            'title' => 'User Registration',
            'bodycontent' => $form . $xtra['data'],
        ];

        
        // Create an instance of the TemplateEngine
        $templateEngine = new TemplateEngine('\\wamp64\\400006369_Framework\\'. '\tpl');

        // Render the template
        $html = $templateEngine->render('Template', $data);

        // Create an instance of the Response
        $response = new Response();

        // Set content type (optional, defaults to text/html)
        $response->setContentType('text/html');

        // Set data for the response
        $response->setData($html);

        // Render the response
        $response->render();
    }
}
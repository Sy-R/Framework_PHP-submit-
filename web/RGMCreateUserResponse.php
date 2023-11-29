<?php
namespace web;

use app\views\TemplateEngine;
use app\controllers\Response;
use app\views\FormGenerator;

class RGMCreateUserResponse
{
    public function index() {

        //initialise errors to empty array
        $errors = '';
        //check for form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
         {
            //Retrieve user input data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            //Create an instance of userValidationController
            $RegValidation = new CreateUserValidationController();

            //call the register method and get the results
            $result = $RegValidation->create($username, $email, $password, $role);

            //Get any errors
            $errors = [];
            if (!empty($result)) {
             foreach ($result as $error) {
                 $errors[] = $error;
                }
}

// Concatenate errors into a single string
$errors = implode('<br>', $errors);
        }

        //Start buffer pass footer for later display.
        ob_start();
        ?>
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
                'content' => $errors,
            ],

            [
                'type' => 'heading3',
                'content' => 'Create a User',
            ],

            [
                'label' => 'Username',
                'type' => 'text',
                'id' => 'username',
                'name' => 'username',
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
                'label' => 'Role',
                'type' => 'select',
                'value' => 'Researcher',
                'options' => [
                'Research Study Manager' => 'Research Study Manager',
                'Researcher' => 'Researcher',
                ],
                'id' => 'role',
                'name' => 'role',
            ],

            [
                'type' =>'submit',
                'class' =>'cntrButton',
                'value' => 'Create',
            ],
        ];

        // $form = FormGenerator::generateForm('LoginResponse.php','post',$fields);
        $form = FormGenerator::generateForm('RGMCreateUser.php','post',$fields);

        
        //Template placeholders information
        $data = [
            'css' => './css/Asn1Styles.css',
            'title' => 'Research Group Manager Create User',
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

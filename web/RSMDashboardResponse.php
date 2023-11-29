<?php
namespace web;

use app\views\TemplateEngine;
use app\controllers\Response;
use framework\Session;

class RSMDashboardResponse {
    public function index() {
        $contentArray = [];
        $session = Session::getInstance();

        ob_start();
        ?>
        <header>
            <img src="research.png" alt="logo">
            <a href="Logout.php">Log out</a>

            <div class="userInfo">
                <p id="userTitle">Research Study Manager: <?php echo $session->getSession('username'); ?></p>
                <p id="userEmail">Email:  <?php echo $session->getSession('email')?></p>
            </div>
        </header>

        <div class="flex-container">
            <div class="flexDiv"><a href="">Create New Study</a></div>
            <div class="flexDiv"><a href="">View All Studies</a></div>
        </div>

        <div class="flex-container">
            <div class="flexDiv"><a href="">Delete Previous Study</a></div>
        </div>

        <footer class="footer">
            <p>Copyright &copy; Nusaybah Rahman. All Rights Reserved</p>
        </footer>
        <?php
        $contentArray['body'] = ob_get_clean();

        $data = [
            'css' => './css/Asn1Styles.css',
            'title' => 'Research Study Manager',
            'bodycontent' => $contentArray['body'],
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



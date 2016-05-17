<?php

use framework\controllers\Main;

class DefaultController extends Main
{
    public function index()
    {
        if(isset($_POST["logout"])) {
            unset($_SESSION["user"]);
        }
        
        if(isset($_SESSION["user"])) {
            $a = $_SESSION["user"];
            $a = unserialize($a);
            $this->mainView->render(BASE_PATH . "/app/view/HomePageView.php", $a);
        }else {
            echo "You are not autorize, sign up<br>" . "<a href='/Registeration'>SIGN UP</a>";
        }
    }
    /*public function logout () {
        if(isset($_POST["logout"])) {
            unset($_SESSION["user"]);
        }
    }*/

}


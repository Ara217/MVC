<?php
use framework\controllers\Main;
//use app\model\Users;

class LoginController extends Main
{

    public function __construct()
    {
        parent:: __construct();
    }

    public $array = array("Login" => "LOGIN PAGE");
    
    public function index ()
    {
        $formInfo = $this->checkInputs($_POST);
        $rowNums = $this->checkData($formInfo);
        $rowNums = (int)$rowNums;
        if ($rowNums === 1) {
            $info = $this->query->select()->from("users")->where($formInfo)->first();
            $info = serialize($info);
            $_SESSION["user"] = $info;
            header ("Location: Default");
        } else {
            $this->array["wrong"] = "Email or password is wrong";
        }
        $this->mainView->render(BASE_PATH . "/app/view/LoginView.php",$this->array);//call view class render method
    }
}
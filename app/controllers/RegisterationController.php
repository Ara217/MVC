<?php
use framework\controllers\Main;

class RegisterationController extends Main
{

    public function __construct()
    {
        parent:: __construct();
    }
    
    public $array = array("Registeration" => "REGISTRATION PAGE");

    public function index ()
    {
        $formInfo = $this->checkInputs($_POST);
        $rowNums = $this->checkData($formInfo);
        $rowNums = (int)$rowNums;
        if ($rowNums === 0) {
           $this->query->insert("users", $formInfo)->callInsert();
        } else {
            $this->array["wrong"] = "Somting wrong";
        }
        $this->mainView->render(BASE_PATH . "/app/view/RegisterationView.php", $this->array);//call view class render method
    }
}
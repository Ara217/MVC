<?php

function __autoload($class)
{
    if (strpos($class, 'PDO') === false) {
        if (strpos($class, 'Controller') === false) {
            require_once BASE_PATH . "/" . $class . ".php";
        } else {
            require_once BASE_PATH . '/app/controllers/' . $class . ".php";
        }
    }
}

class Route
{
    protected $controller;
    protected $action;
    protected $arguments;
    private $segments;

    public function run()
    {
        $this->urlParse();
        $this->callToAction();
    }

    public function urlParse()
    {
        $this->segments = explode('/', (trim($_SERVER['REQUEST_URI'], '/')));
        $this->controllerParse();
        $this->actionParse();
        $this->argumentParse();
    }
    
    
    private function controllerParse()
    {
      $controller = empty($this->segments[0]) ? 'Default' : $this->segments[0];

      if (file_exists("app/controllers/" . $controller . "Controller.php")) {
          $this->controller = $controller . 'Controller';
      } else {
          header("HTTP/1.0 404 Not Found");
          exit;
      }
    }

    private function actionParse()
    {
        $action = isset($this->segments[1]) ? $this->segments[1] : 'index';
        $controller = new $this->controller();

        if (method_exists($controller, $action)) {
            $this->action = $action;
        } else {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
    }

    private function argumentParse()
    {
        if (count($this->segments) > 2) {
            $this->arguments = array_slice($this->segments, 2);
        }
    }

    public function callToAction()
    {
        $class = new $this->controller();//create class objcet and call object method

        if (count($this->segments) > 2) {
            call_user_func_array(array($class, $this->action), $this->arguments);
        } else {
            call_user_func_array(array($class, $this->action), array());
        }
    }
}
<?php

namespace framework\Views;

class View
{ 
    public function render ($path, $option = array())//path - view file path,$option - variables
    {
        extract($option);//this array info using in required homeview.php file
        require_once  $path;
    }
}
?>
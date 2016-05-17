<?php
namespace framework\controllers;//main used in registerationController.php
use framework\Views\View;
use framework\Models\QueryBuilder;

class Main extends QueryBuilder
{
    public $query;
    public $mainView;

    public function __construct()
    {
        $this->query = new QueryBuilder();
        $this->mainView = new View();//create view class new object
    }
}



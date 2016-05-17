<?php
session_start();
require_once "framework/controllers/Route.php";

define('BASE_PATH', __DIR__);

$app = new Route();
$app->run();



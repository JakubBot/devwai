<?php
require_once '../controllers.php'; 
require_once '../../vendor/autoload.php';
// require '../access.php'; //kontrola dostępu
//wybór kontrolera do wywołania:
require_once '../routing.php';
require_once '../dispatcher.php';

// session_start();

$model = [];

$action_url = $_GET['action'];
$controller_name = $routing[$action_url];
render($controller_name($model), $model);

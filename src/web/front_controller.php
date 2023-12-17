<?php
require_once '../controllers.php'; 
require_once '../../vendor/autoload.php';
require_once '../routing.php';
require_once '../dispatcher.php';

ini_set('display_errors', 'Off');

$model = [];

$action_url = $_GET['action'];
$controller_name = $routing[$action_url];
render($controller_name($model), $model);

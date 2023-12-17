<?php

const REDIRECT_PREFIX = 'redirect:';

function dispatch($routing, $action_url)
{
    $controller_name = $routing[$action_url];

    $model = [];
    $view_name = $controller_name($model);

    build_response($view_name, $model);
}

function build_response($view, $model)
{
    if (strpos($view, REDIRECT_PREFIX) === 0) {
        $url = substr($view, strlen(REDIRECT_PREFIX));
        header("Location: " . $url);
        exit;

    } else {
        render($view, $model);
    }
}
// function get_sample_cart() {
//     return [
//         1 => ['name' => 'Product A', 'amount' => 3],
//         2 => ['name' => 'Product B', 'amount' => 5],
//         3 => ['name' => 'Product C', 'amount' => 2],
//     ];
// }

function render($view_name, $model)
{
    global $routing;
    extract($model);
    include 'views/' . $view_name . '.php';
}

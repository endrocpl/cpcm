<?php

$project_location = "";
$me = $project_location;

$request = $_SERVER['REQUEST_URI'];


switch ($request) {
    case $me . '/':
        require "src/views/dashboard.php";
        break;
    case $me . '/customer':
        require "src/views/customer.php";
        break;
    case $me . '/cms':
        require "src/views/dashboard.php";
        break;
    case $me . '/order':
        require "src/views/order.php";
        break;
    case $me . '/users':
        require "src/views/users.php";
        break;
    case $me . '/login':
        require "src/views/login.php";
        break;
    default:
        http_response_code(404);
        echo "404";
        break;
}

<?php

include 'src/database.php';
$db = new Database();
session_start();
$uname =  $_SESSION["username"];
$allCustomer = $db->get_allOrderByUsername($uname);
echo json_encode($allCustomer);

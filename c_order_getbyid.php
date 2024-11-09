<?php
include 'src/database.php';
if (!isset($_POST['orderid'])) die();

$db = new Database();
$allCustomer = $db->get_orderById($_POST['orderid']);
echo json_encode($allCustomer);

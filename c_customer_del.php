<?php
include 'src/database.php';

if (!isset($_POST['custid'])) die();

$db = new Database();
$allCustomer = $db->del_customerById($_POST['custid']);
echo json_encode($allCustomer);

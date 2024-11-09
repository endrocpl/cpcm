<?php
include 'src/database.php';

if (!isset($_POST['custid'])) die();

$db = new Database();
$allCustomer = $db->set_customerActiveById($_POST['valuex'], $_POST['custid']);
echo json_encode($allCustomer);

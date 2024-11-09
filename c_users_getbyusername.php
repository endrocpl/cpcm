<?php
include 'src/database.php';
if (!isset($_POST['username'])) die();

$db = new Database();
$allCustomer = $db->get_usersById($_POST['username']);
echo json_encode($allCustomer);

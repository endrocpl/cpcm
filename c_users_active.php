<?php
include 'src/database.php';
if (!isset($_POST['username'])) die();

$db = new Database();
$allCustomer = $db->set_usersActiveById($_POST['valuex'], $_POST['username']);
echo json_encode($allCustomer);

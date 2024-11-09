<?php
include 'src/database.php';
if (!isset($_POST['username'])) die();

$db = new Database();
$result = $db->del_usersById($_POST['username']);
echo json_encode($result);

<?php
include 'src/database.php';
if (!isset($_POST['orderid'])) die();

$db = new Database();
$res = $db->del_orderById($_POST['orderid']);
echo json_encode($res);

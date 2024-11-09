<?php
include 'src/database.php';
if (!isset($_POST['itemid'])) die();

$db = new Database();
session_start();
$uname =  $_SESSION["username"];
$result = $db->del_lastSeqByUsername($uname, $_POST['itemid']);
echo json_encode($result);

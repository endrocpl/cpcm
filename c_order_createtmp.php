<?php

include 'src/database.php';
if (!isset($_POST['itemid'])) die();

$db = new Database();
session_start();
$uname =  $_SESSION["username"];
$lastSeq = $db->get_lastSeqByUsername($uname);
$allCustomer = $db->add_ordertoTmp($_POST['custid'], $_POST['itemid'], $_POST['name'], $_POST['qty'], $uname, $lastSeq);
echo json_encode($allCustomer);

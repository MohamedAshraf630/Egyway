<?php
require_once('../../database-manager/database-object.php');

$orderId = $_POST['orderId'];
$rate = $_POST['rate'];
$comment = $_POST['comment'];

// Update order in database
$db->where("id", $orderId);
$data = array('rate' => $rate, 'comment' => $comment);
$result = $db->update("orders", $data);
if ($result) {
    header('Location: /egyway/orders.php?message=success');
} else {
    header('Location: /egyway/login.php?message=failed');
}

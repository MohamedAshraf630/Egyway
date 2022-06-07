<?php
require_once('../../database-manager/database-object.php');

$orderId = $_POST['orderId'];
$managerPin = $_POST['managerPin'];

// VAlidate the manager pin
if ($managerPin != "1234") {
    header('Location: /egyway/customer-service/orders.php?message=failed');
} else {
    $db->where('id', $orderId);
    $data = array('isCanceled' => true);
    $db->update("orders", $data);

    header('Location: /egyway/customer-service/orders.php?message=success');
}


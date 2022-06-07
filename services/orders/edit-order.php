<?php
require_once('../../database-manager/database-object.php');

$target_dir = "../../uploads/";
$uploads_prefix = "/uploads/";

$orderId = $_POST["orderId"];
$ordersPassengersIds = $_POST['ordersPassengersIds'];
$names = $_POST['name'];
$nationalIds = $_FILES['nationalId'];
$index = 0;

if (isset($ordersPassengersIds) and isset($names)) {
    foreach ($ordersPassengersIds as $id) {
        // Get the order_passenger from database
        $db->where("id", $id);
        $orderPassenger = $db->getOne("orders_passengers");
        $orderPassenger['name'] = $names[$index];
        // Check if nationalIds needs to be updated
        if (isset($nationalIds)) {
            if (isset($nationalIds["name"][$index])) {
                // Upload to server
                $nationalId_file = basename($nationalIds["name"][$index]);
                move_uploaded_file($nationalIds["tmp_name"][$index], $target_dir . $nationalId_file);
                $orderPassenger['nationalIdUrl'] = $uploads_prefix . $nationalId_file;
            }
        }
        $db->where("id", $id);
        $result = $db->update("orders_passengers", $orderPassenger);
        $index++;
    }
}
// Update the edit date
$now = new DateTime();
$db->where("id", $orderId);
$order = $db->getOne("orders");
$order['date_updated'] = $now->format('Y-m-d H:i:s');
$db->where("id", $orderId);
$updateOrder = $db->update("orders", $order);
header('Location: /egyway/orders.php');

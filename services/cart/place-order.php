<?php
require_once('../../database-manager/database-object.php');
session_start();
$user = $_SESSION['user'];

$target_dir = "../../uploads/";
$uploads_prefix = "/uploads/";

$orderTotal = $_POST['total'];
$flights = $_POST['flights'];
$names = $_POST['name'];
$nationalIds = $_FILES['nationalId'];

if (isset($flights) and isset($names) and isset($nationalIds)) {
    // Prepare the data for order submission
    // 1) Create a new order in the database
    $now = new DateTime();
    $data = array(
        'date_created' => $now->format('Y-m-d H:i:s'),
        'total' => $orderTotal,
        'userId' => $user['id']
    );
    $orderId = $db->insert('orders', $data);

    // 2) Add flights to the order Id
    foreach ($flights as $flightId) {
        $flightData = array('flightId' => $flightId, 'orderId' => $orderId);
        $db->insert('orders_flights', $flightData);
    }

    // 3) Add passengers to the order
    $index = 0;
    foreach ($names as $name) {
        // Upload the nationalId to uploads folder
        $nationalId_file = basename($nationalIds["name"][$index]);
        move_uploaded_file($nationalIds["tmp_name"][$index], $target_dir . $nationalId_file);
        $passengerData = array(
            'name' => $name,
            'nationalIdUrl' => $uploads_prefix . $nationalId_file,
            'orderId' => $orderId
        );
        $db->insert('orders_passengers', $passengerData);
        $index++;
    }
    header('Location: /egyway/success.php?orderId=' . $orderId);
} else {
    header('Location: /egyway/error.php?orderId=' . $orderId);
}

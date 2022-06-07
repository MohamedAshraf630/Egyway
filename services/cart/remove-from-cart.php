<?php
$user = $_SESSION['user'];
$flightId = $_POST["flightId"];
session_start();
if (isset($flightId)) {
    $cart = $_SESSION['cart'][$user['id']];
    // Find the flightId in the array
    $keyToRemove = array_search($flightId, $cart);
    unset($cart[$keyToRemove]);
    $_SESSION['cart'][$user['id']] = $cart;
    http_response_code(200);
} else {
    http_response_code(400);
}

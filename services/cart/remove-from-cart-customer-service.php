<?php
$userId = $_POST["userId"];
$flightId = $_POST["flightId"];
session_start();
if (isset($flightId)) {
    $cart = $_SESSION['cart'][$userId];
    $search_result = $_SESSION['search_result'][$userId]['flights'];
    // Find the flightId in the array
    $cartKeyToRemove = array_search($flightId, $cart);
    $searchResultKeyToRemove = array_search($flightId, $search_result);
    unset($cart[$cartKeyToRemove]);
    unset($search_result[$searchResultKeyToRemove]);
    $_SESSION['cart'][$userId] = $cart;
    $_SESSION['search_result'][$userId]['flights'] = $search_result;
    http_response_code(200);
} else {
    http_response_code(400);
}

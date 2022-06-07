<?php
require_once('../database-manager/database-object.php');
session_start();

$userId = $_POST['userId'];
$flightId = $_POST['flightId'];

if(isset($userId) and isset($flightId)) {
    $cart = $_SESSION['cart'][$userId];
    if(!in_array($flightId,$cart))
    {
        array_push($cart, $flightId);
        $_SESSION['cart'][$userId] = $cart;
    }
    require_once('../flights/set-search-results.php');
}

?>
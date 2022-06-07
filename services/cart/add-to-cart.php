<?php
$flights = json_decode(file_get_contents('php://input'), true);

if (isset($flights)) {
    // Check if the cart isn't empty
    session_start();
    $user = $_SESSION['user'];
    // Check if the cart array is initialized as an array
    if(empty($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }
    if (!empty($_SESSION["cart"][$user['id']])) {
        $merge_arrays = array_merge($_SESSION["cart"][$user['id']], $flights);
        $distinct_array = array_unique($merge_arrays);
        $_SESSION["cart"][$user['id']] = $distinct_array;
    } else {
        $_SESSION["cart"][$user['id']] = $flights;
    }
    http_response_code(200);
} else {
    http_response_code(400);
}

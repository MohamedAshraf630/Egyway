<?php
session_start();
$userId = $_POST['userId'];
// Check if user exists in database
if (isset($userId)) {
    // Get the user from database by email
    unset($_SESSION['cart'][$userId]);
    unset($_SESSION['search_result'][$userId]);
    // If updated
    http_response_code(200);
} else {
    http_response_code(400);
}

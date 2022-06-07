<?php
require_once('../../database-manager/database-object.php');

$userId = $_POST['userId'];
$disableComment = $_POST['disableComment'];
// Check if user exists in database
if (isset($userId)) {
    // Get the user from database by email
    $db->where("id", $userId);
    $data = Array('isDisabled' => true, 'disabledComment' => $disableComment);
    $result = $db->update("users", $data);
    // If updated
    if (isset($result)) {
        http_response_code(200);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400);
}

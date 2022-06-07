<?php
require_once('../../database-manager/database-object.php');

$airports = $db->get("airport_list");
$airportsDropdown = array();

foreach ($airports as $value) {
    array_push($airportsDropdown, array('value' => $value['id'], 'label' => $value['airport']));
}

// Allow CORS policy, so any server can access this server
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
echo json_encode($airportsDropdown);
exit();

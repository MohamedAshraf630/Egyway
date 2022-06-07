<?php
require_once('../../database-manager/database-object.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");

$_POST = json_decode(file_get_contents("php://input"), true);

$goingFrom = $_POST['leavingFrom'];
$goingTo = $_POST['goingTo'];
$dateFrom = date('d-m-Y', strtotime($_POST['dateFrom']));
$dateTo = date('d-m-Y', strtotime($_POST['dateTo']));


// query the departure flights
$db->where("departure_airport_id", $goingFrom)->where("arrival_airport_id", $goingTo);
$deptFlights = $db->get("flight_list");

// query the returning flights
$db->where("departure_airport_id", $goingTo)->where("arrival_airport_id", $goingFrom);
$returnFlights = $db->get("flight_list");

$filteredDeptFlights = array();
$filteredReturnFlights = array();
// Filter departure flights by dateFrom and dateTo
foreach ($deptFlights as $flight) {
    $flightDeptDate = date('d-m-Y', strtotime($flight['departure_datetime']));
    // Check if Dept date matches the dateFrom
    if ($dateFrom == $flightDeptDate) {
        array_push($filteredDeptFlights, array(
            'id' => $flight['id'],
            'plane_no' => $flight['plane_no'],
            'dept_date' => date('h:i a', strtotime($flight['departure_datetime'])),
            'arrival_date' => date('h:i a', strtotime($flight['arrival_datetime'])),
            'price' => $flight['price']
        ));
    }
}

// Filter return flights by dateFrom and dateTo
foreach ($returnFlights as $flight) {
    $flightDeptDate = date('d-m-Y', strtotime($flight['departure_datetime']));
    // Check if Dept date matches the dateFrom
    if ($dateTo == $flightDeptDate) {
        array_push($filteredReturnFlights, array(
            'id' => $flight['id'],
            'plane_no' => $flight['plane_no'],
            'dept_date' => date('h:i a', strtotime($flight['departure_datetime'])),
            'arrival_date' => date('h:i a', strtotime($flight['arrival_datetime'])),
            'price' => $flight['price']
        ));
    }
}

// Allow CORS policy, so any server can access this server
header("Content-Type: application/json");
$result = array('dept_flights' => $filteredDeptFlights, 'arrival_flights' => $filteredReturnFlights);
echo json_encode($result);
exit();

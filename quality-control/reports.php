<?php require_once('../layout/header.php') ?>
<?php require_once('../layout/validate-user.php') ?>
<?php require_once('../database-manager/database-object.php'); ?>
<?php require_once('../layout/validate-quality-control.php') ?>
<?php
$byUser = array(5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0);
$byFlights = array();
$mostOrderedCount = array();
// ### BY USER
$editedReservations = 0;
$orders = $db->get("orders");
foreach ($orders as $order) {
    if ($order['rate'] != 0) {
        $byUser[$order['rate']]++;
    }

    // ### How many travellers edited their reservations ?
    if (isset($order['date_updated'])) {
        $editedReservations++;
    }
}
// ### BY FLIGHT
$flights = $db->get("flight_list");
foreach ($flights as $flight) {
    $db->where("id", $flight['departure_airport_id']);
    $departureAirport = $db->getOne("airport_list");

    $db->where("id", $flight['arrival_airport_id']);
    $arrivalAirport = $db->getOne("airport_list");

    // Get from the orders_flights table the flights matching the flightId
    $db->where("flightId", $flight['id']);
    $ordersFlights = $db->get("orders_flights");

    // Get the 5 star ratings from the orders of the orders_flights
    $flight5Star = 0;
    foreach ($ordersFlights as $orderFlight) {
        $db->where("id", $orderFlight['orderId']);
        $order = $db->getOne("orders");
        if ($order['rate'] == 5) {
            $flight5Star++;
        }
    }
    array_push($byFlights, '<li class="list-group-item"><div>' . $flight['plane_no'] . '</div><small>Dept: ' . $departureAirport['airport'] . ' - Arrive: ' . $arrivalAirport['airport'] . '</small> <b class="float-right">' . $flight5Star . '</b></li>');
}

// ### MOST ORDERED FLIGHTS
$allOrdersFlights = $db->get("orders_flights");
foreach($allOrdersFlights as $orderFlight) {
    if(!isset($mostOrderedCount[$orderFlight['flightId']])) {
        $mostOrderedCount[$orderFlight['flightId']] = 0;
    }
    $mostOrderedCount[$orderFlight['flightId']]++;
}
$mostOrderedFlightId = max($mostOrderedCount);
$db->where("id", $mostOrderedFlightId);
$mostOrderedFlight = $db->getOne("flight_list");
$db->where("id", $mostOrderedFlight['departure_airport_id']);
$departureAirport = $db->getOne("airport_list");

$db->where("id", $mostOrderedFlight['arrival_airport_id']);
$arrivalAirport = $db->getOne("airport_list");
?>

<div class="container py-5">
    <h2>Ratings Reports</h2>
    <div class="card my-2">
        <div class="card-body">
            <h4>By User</h4>
            <ul class="list-group">
                <?php
                $index = 5;
                foreach ($byUser as $rate) {
                    echo '<li class="list-group-item">' . $index-- . ' Star <b class="float-right">' . $rate . ' User</b></li>';
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="card my-4">
        <div class="card-body">
            <h4>By Flight (5 Star Rating)</h4>
            <ul class="list-group">
                <?php
                $index = 5;
                foreach ($byFlights as $flight) {
                    echo $flight;
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="card my-4">
        <div class="card-body">
            <h4>How many travellers edited their reservations ?</h4>
            <?php echo $editedReservations; ?>
        </div>
    </div>
    <div class="card my-4">
        <div class="card-body">
            <h4>What is the most ordered flight ?</h4>
            <?php echo '<b>'. $mostOrderedFlight['plane_no'].'</b><br>';
                  echo $departureAirport['airport']."<br>" ;
                  echo $arrivalAirport['airport'];?>
        </div>
    </div>
    
    <div> <a class="btn btn-success" href="/egyway/"> Back</a></div>
</div>

<?php require_once('../layout/footer.php') ?>
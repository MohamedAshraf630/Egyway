<?php require_once('layout/header.php') ?>
<?php require_once('layout/validate-user.php') ?>
<?php require_once('database-manager/database-object.php'); ?>

<?php
$orderId = '';
// Fetch the flights from database
parse_str($_SERVER['QUERY_STRING'], $queries);
if (isset($queries) && count($queries) > 0) {
    // Check if there is an error then set it.
    $orderId = $queries['orderId'];
}
$flights = [];
$passengers = [];
// Get the order from database
$db->where("id", $orderId);
$order = $db->getOne("orders");
// Get the order_flights from database
$db->where("orderId", $orderId);
$orderFlights = $db->get("orders_flights");
// Get the passenger_orders from database
$db->where("orderId", $orderId);
$orderPassengers = $db->get("orders_passengers");
$counter = 1;
if (isset($orderFlights)) {
    foreach ($orderFlights as $orderflight) {
        // Get the user from database by email
        $db->where("id", $orderflight['flightId']);
        $flight = $db->getOne("flight_list");

        $db->where("id", $flight['departure_airport_id']);
        $dept_airport = $db->getOne("airport_list");

        $db->where("id", $flight['arrival_airport_id']);
        $arrival_airport = $db->getOne("airport_list");

        array_push($flights, array(
            'id' => $flight['id'],
            'flight_number' => $flight['plane_no'],
            'dept_date' => date('d-M-Y h:i a', strtotime($flight['departure_datetime'])),
            'arrival_date' => date('d-M-Y h:i a', strtotime($flight['arrival_datetime'])),
            'dept_airport' => $dept_airport['airport'],
            'arrival_airport' => $arrival_airport['airport'],
            'price' => $flight['price']
        ));
    }
}


?>

<section class="h-100">
    <div class="container py-3 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card">
                    <div class="card-body p-4">
                        <!-- Passengers -->
                        <form method="POST" action="services/orders/edit-order.php" enctype="multipart/form-data">
                            <?php echo '<input name="orderId" type="hidden" value="' . $orderId . '" />'; ?>
                            <div class="row">

                                <div class="col-12">
                                    <h5 class="mb-3"><a href="/egyway/orders.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to Orders</a></h5>
                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <p class="mb-1">Edit your order</p>
                                            <p class="mb-0">You have <?php echo count($flights); ?> flights selected</p>
                                        </div>
                                    </div>

                                    <?php foreach ($flights as $flight) {
                                        echo '<div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="ms-3">
                                                        <h5>' . $flight['flight_number'] . '</h5>
                                                        <p class="small mb-0"><b>Departure:</b> ' . $flight['dept_airport'] . '</p>
                                                        <p class="small mb-2">' . $flight['dept_date'] . '</p>
                                                        <p class="small mb-0"><b>Arrival:</b> ' . $flight['arrival_airport'] . '</p>
                                                        <p class="small mb-1">' . $flight['arrival_date'] . '</p>

                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div style="width: 120px;">
                                                        <h5 class="mb-0">
                                                            <p class="price">' . $flight['price'] . '</p> EGP
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                    }
                                    ?>
                                    <div>
                                        <h5 class="pr-2">Passengers</h5>
                                        <hr />
                                    </div>
                                    <div class="row" id="passengers">
                                        <?php foreach ($flights as $flight) {
                                            echo '<input name="flights[]" type="hidden" value=' . $flight['id'] . ' />';
                                        } ?>
                                        <div class="col-12">
                                            <?php foreach ($orderPassengers as $passenger) {
                                                echo ' <div class="row">
                                                <div class="col-1">
                                                    <div class="mt-4">' . $counter++ . '</div>
                                                    <input type="hidden" name="ordersPassengersIds[]" value="' . $passenger['id'] . '" />
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input required class="form-control" name="name[]" value=' . $passenger['name'] . ' placeholder="Name..." />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>National Id</label>
                                                        <input type="file" class="form-control" name="nationalId[]" />
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <img style="margin-top: 32px;" src="/egyway' . $passenger['nationalIdUrl'] . '" width="80" />
                                                </div>
                                            </div>';
                                            } ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card bg-primary text-white rounded-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-2">Total</p>
                                                <p class="mb-2 total"><?php echo $order['total']; ?> EGP</p>
                                            </div>
                                            <button type="submit" class="btn btn-info btn-block btn-lg">
                                                <div class="d-flex justify-content-between">
                                                    <span class="total"><?php echo $order['total']; ?> EGP</span>
                                                    <span>Save Changes <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php require_once('layout/footer.php') ?>
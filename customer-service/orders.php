<?php require_once('../layout/header.php') ?>
<?php require_once('../layout/validate-user.php') ?>
<?php require_once('../database-manager/database-object.php'); ?>
<?php require_once('../layout/validate-customer-service.php') ?>

<?php
$orders = $db->get("orders");
$error="";
// Check if there is a query string, then retrive it to show the error.
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
if (isset($queries) && count($queries) > 0) {
    // Check if there is an error then set it.
    $error = $queries['message'];
}

?>

<div class="container my-5">
    <h4>User Orders</h4>
    <?php
    if ($error == 'failed') {
        echo '<div class="bg-danger mt-4 mb-4 p-2">Manager pin is invalid</div>';
    }
    ?>
    <div class="row">
        <?php foreach ($orders as $order) {
            $db->where("id", $order['userId']);
            $user = $db->getOne("users");
            $db->where("orderId", $order['id']);
            $flights = $db->get("orders_flights");
            // ### Validate the comment feature
            $rate = '';
            $comment = '';
            if (isset($order['rate']) and isset($order['comment'])) {
                $rate = 'Rate: ' . $order['rate'] . ' / 5';
                $comment = $order['comment'];
            }
            // Get the flights details 
            $flightsText = '';
            foreach ($flights as $orderFlight) {
                $db->where("id", $orderFlight['flightId']);
                $flight = $db->getOne("flight_list");
                $flightsText .= '<small>' . $flight['plane_no'] . '</small><br />';
            }

            // Get the passengers
            $passengersText = '';
            $db->where("orderId", $order['id']);
            $ordersPassengers = $db->get("orders_passengers");
            foreach ($ordersPassengers as $pass) {
                $passengersText .= '<small>' . $pass['name'] . '</small><br />';
            }

            // Cancel order feature
            $cancelOrderFeature = '<a class="btn btn-outline-danger mt-2" onclick="handleDeleteOrderClick(' . $order['id'] . ')" href="" data-toggle="modal" data-target="#deleteOrderModal">Delete Order</a>';
            $cancelOrderBadge = '';
            if ($order['isCanceled']) {
                $cancelOrderFeature = '';
                $cancelOrderBadge = '<div class="badge badge-danger">Canceled</div>';
            }

            echo '
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3>' . $user['name'] . '</h3>
                        ' . $cancelOrderBadge . '
                        <div class="row">
                            <div class="col-8">
                                <b>Order #' . $order['id'] . '</b> ( ' . $order['date_created'] . ' )
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <b>Booked Flights</b>
                                        <br>
                                        ' . $flightsText  . '
                                    </div>
                                    <div class="col-6">
                                        <b>Passengers</b>
                                        <br>
                                        ' . $passengersText . '
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <h6>' . $rate . '</h6>
                                ' . $comment . '
                            </div>
                            <div class="col-12">
                                ' . $cancelOrderFeature . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>
<?php require_once('../popups/delete-order-modal.php'); ?>

<script>
    function handleDeleteOrderClick(orderId) {
        $('#orderId').val(orderId);

    }
</script>


<?php require_once('../layout/footer.php') ?>
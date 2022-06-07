<?php require_once('layout/header.php') ?>
<?php require_once('layout/validate-user.php') ?>
<?php require_once('database-manager/database-object.php'); ?>
<?php

$user = $_SESSION["user"];
// Get the orders from database
$db->where("userId", $user['id']);
$orders = $db->get("orders");
?>

<div class="container">
    <h3>My Orders</h3>
    <div class="row">
        <?php foreach ($orders as $order) {
            $db->where("orderId", $order['id']);
            $flights = $db->get("orders_flights");
            // ### Validate if can edit (Calcuate time difference between now and date_created)
            $editFeature = '<a class="mr-3" href="/egyway/edit-order.php?orderId=' . $order['id'] . '">Edit Details</a>';
            $now = new DateTime();
            $orderDate = new DateTime($order['date_created']);
            $diff = date_diff($now, $orderDate);
            $minutesDiff = $diff->days * 24 * 60;
            $minutesDiff += $diff->h * 60;
            $minutesDiff += $diff->i;
            if ($minutesDiff > 5) {
                $editFeature = '';
            }
            // ### Validate the comment feature
            $commentFeature = '<a onclick="handleRateCommentClick(' . $order['id'] . ')" href="" data-toggle="modal" data-target="#rateCommentModal">Rate & Comment</a>';
            $rate = '';
            $comment = '';
            if (isset($order['rate']) and isset($order['comment'])) {
                $commentFeature = '';
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
            $cancelOrderBadge = '';
            if ($order['isCanceled']) {
                $cancelOrderBadge = '<div class="badge badge-danger">Canceled</div>';
            }


            echo '
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
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
                                ' . $editFeature . '
                                ' . $commentFeature . '
                            </div>
                            <div class="col-4">
                                <h6>' . $rate . '</h6>
                                ' . $comment . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>
<?php require_once('popups/rate-comment-modal.php'); ?>


<script>
    function handleRateCommentClick(orderId) {
        $('#orderId').val(orderId);

    }
</script>
<?php require_once('layout/footer.php') ?>
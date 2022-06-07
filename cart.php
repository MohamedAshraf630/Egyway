<?php require_once('layout/header.php') ?>
<?php require_once('layout/validate-user.php') ?>
<?php require_once('database-manager/database-object.php'); ?>

<?php
// Fetch the flights from database
$user = $_SESSION['user'];
$flights = [];
if (isset($_SESSION["cart"][$user['id']])) {
    foreach ($_SESSION["cart"][$user['id']] as $flightId) {
        // Get the user from database by email
        $db->where("id", $flightId);
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
                    <?php if (isset($_SESSION["cart"][$user['id']]) and count($_SESSION["cart"][$user['id']]) > 0) {
                        echo '<div class="card-body p-4">

                        <div class="row">

                            <div class="col-12">
                                <h5 class="mb-3"><a href="/egyway/" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to Home</a></h5>
                                <hr>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <p class="mb-1">Shopping cart</p>
                                        <p class="mb-0">You have <?php echo count($flights); ?> flights in your cart</p>
                                    </div>
                                </div>';

                        foreach ($flights as $flight) {
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
                                                            <h5 class="mb-0"><p class="price">' . $flight['price'] . '</p> EGP</h5>
                                                        </div>
                                                        <a onclick="handleRemoveFromCartClick(' . $flight['id'] . ')" href="#!" class="text-danger"><i class="fas fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                        }

                        echo '                                
                        <!-- Passengers -->
                        <form method="POST" action="services/cart/place-order.php" enctype="multipart/form-data">
                        <div>
                                    <h5 class="pr-2">Passengers</h5>
                                    <button type="button" class="btn btn-success mr-2" onclick="handleAddPassenger()">Add Passenger</button>
                                    <button type="button" class="btn btn-danger mx-2" onclick="handleRemovePassenger()">Remove Passenger</button>
                                    <hr />

                                </div>

                                    <div class="row" id="passengers">';
                        foreach ($flights as $flight) {
                            echo '<input name="flights[]" type="hidden" value=' . $flight['id'] . ' />';
                        }
                        echo '<input id="form-total" name="total" type="hidden" value="" />';
                        echo '<div class="col-12">
                                            <div class="row">
                                                <div class="col-1">
                                                    <div class="mt-4">1</div>
                                                </div>
                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input required class="form-control" name="name[]" placeholder="Name..." />
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label>National Id</label>
                                                        <input required type="file" class="form-control" name="nationalId[]" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-12">

                                <div class="card bg-primary text-white rounded-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-4">
                                            <p class="mb-2">Total</p>
                                            <p class="mb-2 total"></p>
                                        </div>

                                        <button type="submit" class="btn btn-info btn-block btn-lg">
                                            <div class="d-flex justify-content-between">
                                                <span class="total"></span>
                                                <span>Place Order <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                            </div>
                                        </button>

                                    </div>
                                </div>

                            </div>
                            </form>

                        </div>

                    </div>';
                    }
                    ?>

                    <?php if (!isset($_SESSION["cart"]) or count($_SESSION["cart"]) == 0) {
                        echo '<h3 class="p-4">No flights found. Please add first to proceed</h3>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let rowsCount = 1;
    let basePrice = 0;
    let total = 0;
    $('.price').each(function() {
        basePrice += Number($(this).text());
        total += basePrice;
    });
    $('.total').text(basePrice);
    $('#form-total').val(basePrice);


    let row = function(rowId) {
        return `<div id="${rowId}" class="col-12">
                    <div class="row">
                        <div class="col-1">
                            <div class="mt-4">${rowId}</div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" name="name[]" placeholder="Name..." />
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label>National Id</label>
                                <input type="file" class="form-control" name="nationalId[]" />
                            </div>
                        </div>
                    </div>
                </div>`;
    }

    function handleAddPassenger() {
        rowsCount += 1;
        total = basePrice * rowsCount;
        $('#passengers').append(row(rowsCount));
        $('.total').text(total);
        $('#form-total').val(total);
    }

    function handleRemovePassenger(e) {
        if (rowsCount == 1) {
            return;
        }
        $('#passengers').find('#' + rowsCount).remove();
        rowsCount -= 1;
        total = basePrice * rowsCount;
        $('.total').text(total);
        $('#form-total').val(total);
    }

    function handleRemoveFromCartClick(flightId) {
        let ajaxData = 'flightId=' + flightId;
        $.ajax({
            type: "POST",
            url: "services/cart/remove-from-cart.php",
            dataType: "json",
            data: ajaxData,
            success: function(data) {}
        });
        location.reload();
        alert("Removed from cart successfully !")
    }
</script>
<?php require_once('layout/footer.php') ?>
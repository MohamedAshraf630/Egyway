<?php require_once('layout/header.php') ?>
<?php require_once('layout/validate-user.php') ?>
<?php require_once('database-manager/database-object.php'); ?>
<?php
// FORM POST
$goingFrom = $_POST['goingFrom'];
$goingTo = $_POST['goingTo'];
$dateFrom = date('d-m-Y', strtotime($_POST['dateFrom']));
$dateTo = date('d-m-Y', strtotime($_POST['dateTo']));

// Multiple destinations
$goingFromMultiples = isset($_POST['goingFromMultiple']) ? $_POST['goingFromMultiple'] : array();
$goingToMultiples = isset($_POST['goingToMultiple']) ? $_POST['goingToMultiple'] : array();
$dateFromMultiples = isset($_POST['dateFromMultiple']) ? $_POST['dateFromMultiple'] : array();
$dateToMultiples = isset($_POST['dateToMultiple']) ? $_POST['dateToMultiple'] : array();

// query the departure flights
$db->where("departure_airport_id", $goingFrom)->where("arrival_airport_id", $goingTo);
$deptFlights = $db->get("flight_list");

// query the returning flights
$db->where("departure_airport_id", $goingTo)->where("arrival_airport_id", $goingFrom);
$returnFlights = $db->get("flight_list");

// RESULTS TO DISPLAY IN HTML
$filteredDeptFlights = '';
$filteredReturnFlights = '';

// Filter departure flights by dateFrom and dateTo
foreach ($deptFlights as $flight) {
	$flightDeptDate = date('d-m-Y', strtotime($flight['departure_datetime']));
	// Check if Dept date matches the dateFrom
	if ($dateFrom == $flightDeptDate) {
		$filteredDeptFlights .= '<div class="col-12 mt-2">' .
			'<div class="card">' .
			'<div class="card-body">' .
			'<h4>' . $flight['plane_no'] . '</h4>' .
			'<b>' . 'Departure: ' . date('h:i a', strtotime($flight['departure_datetime']))  . ' - Arrival: ' . date('h:i a', strtotime($flight['arrival_datetime'])) . '</b>' .
			'<div class="float-right">' .
			'Book Flight ? <input type="checkbox" value="' . $flight['id'] . '" />' .
			'<p>' . $flight['price']  . ' EGP</p>' .
			'</div>' .
			'</div>' .
			'</div>' .
			'</div>';
	}
}

// Filter return flights by dateFrom and dateTo
foreach ($returnFlights as $flight) {
	$flightDeptDate = date('d-m-Y', strtotime($flight['departure_datetime']));
	// Check if Dept date matches the dateFrom
	if ($dateTo == $flightDeptDate) {
		$filteredReturnFlights .= '<div class="col-12 mt-2">' .
			'<div class="card">' .
			'<div class="card-body">' .
			'<h4>' . $flight['plane_no'] . '</h4>' .
			'<b>' . 'Departure: ' . date('h:i a', strtotime($flight['departure_datetime']))  . ' - Arrival: ' . date('h:i a', strtotime($flight['arrival_datetime'])) . '</b>' .
			'<div class="float-right">' .
			'Book Flight ? <input type="checkbox" value="' . $flight['id'] . '" />' .
			'<p>' . $flight['price']  . ' EGP</p>' .
			'</div>' .
			'</div>' .
			'</div>' .
			'</div>';
	}
}

// Loop on all multiple destination
for ($index = 0; $index < count($dateFromMultiples); $index++) {
	if (isset($goingFromMultiples[$index]) and isset($goingToMultiples[$index])) {
		// query the departure flights
		$db->where("departure_airport_id", $goingFromMultiples[$index])->where("arrival_airport_id", $goingToMultiples[$index]);
		$deptFlightsMultiple = $db->get("flight_list");

		// query the returning flights
		$db->where("departure_airport_id", $goingToMultiples[$index])->where("arrival_airport_id", $goingFromMultiples[$index]);
		$returnFlightsMultiple = $db->get("flight_list");

		// Filter departure flights by dateFrom and dateTo
		foreach ($deptFlightsMultiple as $flight) {
			$flightDeptDate = date('d-m-Y', strtotime($flight['departure_datetime']));
			$dateFromMulti = date('d-m-Y', strtotime($dateFromMultiples[$index]));
			// Check if Dept date matches the dateFrom
			if ($dateFromMulti == $flightDeptDate) {
				$filteredDeptFlights .= '<div class="col-12 mt-2">' .
					'<div class="card">' .
					'<div class="card-body">' .
					'<h4>' . $flight['plane_no'] . '</h4>' .
					'<b>' . 'Departure: ' . date('h:i a', strtotime($flight['departure_datetime']))  . ' - Arrival: ' . date('h:i a', strtotime($flight['arrival_datetime'])) . '</b>' .
					'<div class="float-right">' .
					'Book Flight ? <input type="checkbox" value="' . $flight['id'] . '" />' .
					'<p>' . $flight['price']  . ' EGP</p>' .
					'</div>' .
					'</div>' .
					'</div>' .
					'</div>';
			}
		}

		// Filter return flights by dateFrom and dateTo
		foreach ($returnFlightsMultiple as $flight) {
			$flightDeptDate = date('d-m-Y', strtotime($flight['departure_datetime']));
			$dateToMulti = date('d-m-Y', strtotime($dateToMultiples[$index]));
			// Check if Dept date matches the dateFrom
			if ($dateToMulti == $flightDeptDate) {
				$filteredReturnFlights .= '<div class="col-12 mt-2">' .
					'<div class="card">' .
					'<div class="card-body">' .
					'<h4>' . $flight['plane_no'] . '</h4>' .
					'<b>' . 'Departure: ' . date('h:i a', strtotime($flight['departure_datetime']))  . ' - Arrival: ' . date('h:i a', strtotime($flight['arrival_datetime'])) . '</b>' .
					'<div class="float-right">' .
					'Book Flight ? <input type="checkbox" value="' . $flight['id'] . '" />' .
					'<p>' . $flight['price']  . ' EGP</p>' .
					'</div>' .
					'</div>' .
					'</div>' .
					'</div>';
			}
		}
	} else {
		break;
	}
}
?>
<div class="container my-5">
	<div class="row mt-2">
		<div class="col-12">
			<h5>Search results</h5>
			<a href="/egyway/">Back to Search</a>
		</div>
		<div class="col-12 mt-4">
			<h3>Departure Flights</h3>
			<div class="row">
				<?php echo $filteredDeptFlights ?>
			</div>
		</div>
		<div class="col-12 mt-4">
			<h3>Return Flights</h3>
			<div class="row">
				<?php echo $filteredReturnFlights ?>
			</div>
		</div>
		<div class="col-12">
			<button onclick="handleAddToCart()" class="btn btn-primary mt-2 float-right">Add To Cart</button>
		</div>

	</div>
</div>

<script>
	function handleAddToCart() {
		let flights = [];
		$("input[type='checkbox']:checked").each(function() {
			flights.push(this.value);
		});
		// Post to add to cart service
		const ajaxData = JSON.stringify(flights);
		$.ajax({
			type: "POST",
			url: "services/cart/add-to-cart.php",
			dataType: "json",
			data: ajaxData,
			success: function(msg) {}
		});
		alert("Added to cart successfully!");
		location.replace('cart.php')
	}
</script>

<?php require_once('layout/footer.php') ?>
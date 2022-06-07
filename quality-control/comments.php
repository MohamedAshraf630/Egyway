<?php require_once('../layout/header.php') ?>
<?php require_once('../layout/validate-user.php') ?>
<?php require_once('../database-manager/database-object.php'); ?>
<?php require_once('../layout/validate-quality-control.php') ?>
<?php
$orders = $db->get("orders");
$tableContent = '';
foreach ($orders as $order) {
    if (isset($order['comment'])) {
        // Get the user
        $db->where("id", $order['userId']);
        $user = $db->getOne("users");
        $tableContent .= '<tr>
                        <td>' . $order['id'] . '</td>
                        <td>' . $user['name'] . '</td>
                        <td>' . $order['rate'] . '</td>
                        <td>' . $order['comment'] . '</td>
                    </tr>';
    }
}

?>

<div class="container py-5">
    <h2>Traveler Comments</h2>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Order #</th>
                <th>User</th>
                <th>Rate</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $tableContent; ?>
        </tbody>

    </table>

    <div> <a class="btn btn-success" href="/egyway/"> Back</a></div>
</div>


<?php require_once('../layout/footer.php') ?>
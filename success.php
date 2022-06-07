<?php require_once('layout/header.php') ?>
<?php require_once('layout/validate-user.php') ?>
<?php require_once('database-manager/database-object.php'); ?>
<?php
unset($_SESSION["cart"]);
?>
<div class="h-100">
    <div class="container h-100">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="card">
                <div class="card-body">
                    <h2>Your order has been placed successfully!</h2>
                    <a href="/egyway/">Go Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('layout/footer.php') ?>
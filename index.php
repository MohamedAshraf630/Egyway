<?php require_once('layout/header.php') ?>
<?php require_once('layout/validate-user.php') ?>
<?php require_once('database-manager/database-object.php'); ?>
<?php

$role = $_SESSION['user']['role'];
if ($role == 'customerService') {
    require_once('home/home-customer-service.php');
} else if ($role == 'qualityControl') {
    require_once('home/home-quality-control.php');
} else {
    require_once('home/home-customer.php');
}
?>
<?php require_once('layout/footer.php') ?>

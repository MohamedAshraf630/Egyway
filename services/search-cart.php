<?php
require_once('../database-manager/database-object.php');

session_start();
$_SESSION['search_criteria'] = $_POST['search'];
require_once('../flights/set-search-results.php');
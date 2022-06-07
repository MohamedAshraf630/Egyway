<?php
require_once('../database-manager/database-object.php');
$target_dir = "../uploads/";
$uploads_prefix = "/uploads/";
$nationalId_file = basename($_FILES["nationalIdImage"]["name"]);
$picture_file = basename($_FILES["pictureImage"]["name"]);

// Upload files to server
$uploadedNationalId = move_uploaded_file($_FILES["nationalIdImage"]["tmp_name"], $target_dir . $nationalId_file);
$uploadedPictureImage = move_uploaded_file($_FILES["pictureImage"]["tmp_name"], $target_dir . $picture_file);

// Check if upload is successful
if (!$uploadedNationalId or !$uploadedPictureImage) {
    header('Location: /egyway/signup.php?error=failedToUploadImage');
}

$data = array(
    "name" => $_POST["name"],
    "email" => $_POST["email"],
    "password" => $_POST["password"],
    "nationalIdUrl" => $uploads_prefix . $nationalId_file,
    "pictureUrl" => $uploads_prefix . $picture_file,
    "role" => "customer",
    "status" => "pending"
);
$id = $db->insert('users', $data);

if ($id) {
    header('Location: /egyway/login.php'); // Pass query string to the login.php
} else {
    header('Location: /egyway/signup.php?error=failed');
}

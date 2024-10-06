<?php
session_start();
include "../php/connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location:../index.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Initialize feedback variables
$toastMessage = "";
$toastType = "success"; // Default to success, change if an error occurs
$sql = ""; // Initialize $sql to avoid undefined variable error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $regno = mysqli_real_escape_string($conn, $_POST['regno']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);

    // Update query without profile picture
    $sql = "UPDATE students SET firstname='$firstname', lastname='$lastname', email='$email', phone='$phone', regno='$regno', class='$class' WHERE id='$userId'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        $toastMessage = "Personal information updated successfully.";
        $toastType = "success";
    } else {
        $toastMessage = "Error updating personal information: " . mysqli_error($conn);
        $toastType = "error";
    }
}

// Set session variables for the toast notification
$_SESSION['toast_message'] = $toastMessage;
$_SESSION['toast_type'] = $toastType;

header("Location: settings.php");
exit();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = mysqli_real_escape_string($conn, $_POST['old_password']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Fetch current password from database
    $sql = "SELECT password FROM students WHERE id='$userId'";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);

    if (password_verify($oldPassword, $student['password'])) {
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE students SET password='$hashedPassword' WHERE id='$userId'";
            if (mysqli_query($conn, $sql)) {
                $toastMessage = "Password updated successfully.";
            } else {
                $toastMessage = "Error updating password: " . mysqli_error($conn);
                $toastType = "error";
            }
        } else {
            $toastMessage = "New password and confirmation do not match.";
            $toastType = "error";
        }
    } else {
        $toastMessage = "Current password is incorrect.";
        $toastType = "error";
    }
}

// Set session variables for the toast notification
$_SESSION['toast_message'] = $toastMessage;
$_SESSION['toast_type'] = $toastType;

header("Location: settings.php");
exit();

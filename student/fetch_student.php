<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../php/connect.php";

// Fetch students based on the email provided
if (isset($_GET['email'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $query = "SELECT id, email FROM students WHERE email LIKE '%$email%'";
    $result = mysqli_query($conn, $query);
    $students = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }

    echo json_encode($students);
}
?>

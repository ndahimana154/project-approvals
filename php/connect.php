<?php

$conn = new mysqli("localhost", "root", "" , "project_approval");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
<?php
include './connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM students WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Email already exists']);
    } else {
        // Insert new user
        $insertQuery = "INSERT INTO students (firstName, lastName, email, phoneNumber, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phoneNumber, $password);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['message' => 'Registration successful']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Registration failed']);
        }
    }
}

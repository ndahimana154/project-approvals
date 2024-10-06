<?php
include './connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists
    $checkUserQuery = "SELECT * FROM students WHERE email = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            http_response_code(200);
            echo json_encode(['message' => 'Login successful']);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Incorrect password']);
        }
    } else {
        http_response_code(404); // Not found
        echo json_encode(['message' => 'User not found']);
    }
}

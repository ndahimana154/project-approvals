<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './php/connect.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Project Approval System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: rgba(255, 193, 7, 0.2);">
    <?php

    $registerError = $registerSuccess = $loginError = '';
    $firstName = $lastName = $email = $phoneNumber = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $checkEmailQuery = "SELECT * FROM students WHERE email = '$email'";
        $result = mysqli_query($conn, $checkEmailQuery);

        if (mysqli_num_rows($result) > 0) {
            $registerError = 'Email already exists';
        } else {
            $insertQuery = "INSERT INTO students (firstname, lastname, email, phone, password) VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$password')";
            if (mysqli_query($conn, $insertQuery)) {
                $registerSuccess = 'Registration successful';
            } else {
                $registerError = 'Registration failed';
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $checkUserQuery = "SELECT * FROM students WHERE email = '$email'";
        $result = mysqli_query($conn, $checkUserQuery);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user;
                header("Location: ./student/dashboard.php");
                exit();
            } else {
                $loginError = 'Invalid password';
            }
        } else {
            $checkHOD = mysqli_query($conn, "SELECT * from users WHERE email = '$email'");
            if (mysqli_num_rows($checkHOD) < 1) {
                $loginError = 'Email not found';
            } else {
                $user = mysqli_fetch_array($checkHOD);
                if ($user["password"] === $password) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user'] = $user;
                    header("Location: ./admin/dashboard.php");
                    exit();
                } else {
                    $loginError = 'Invalid password';
                }
            }
        }
    }
    ?>
    <header class="text-center py-5">
        <div class="title">
            <p class="lead">Coding is today's language of creativity</p>
            <h1>Project Approval System</h1>
        </div>
        <div class="buttons mt-4">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#registerModal"
                onclick="clearModal()">Register</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        </div>
    </header>

    <!-- User Guidance Section -->
    <div class="container my-5">
        <h2>Welcome to the Project Approval System</h2>
        <p>
            This system is designed to facilitate the management and approval of various projects within the organization.
            Users can register as students or administrators to access different functionalities based on their roles.
        </p>
        <h3>How to Use the System</h3>
        <ol>
            <li><strong>Registration:</strong> Click on the "Register" button to create a new account. Fill out the registration form with your personal details, including your first name, last name, email, phone number, and password.</li>
            <li><strong>Login:</strong> After registering, you can log in using your email and password by clicking on the "Login" button.</li>
            <li><strong>Dashboard:</strong> Once logged in, you will have access to your dashboard, where you can view and manage projects based on your role (student or admin).</li>
            <li><strong>Support:</strong> If you encounter any issues, please reach out to the support team for assistance.</li>
        </ol>
    </div>

    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="registerFirstName" class="form-label">Firstname</label>
                            <input type="text" class="form-control" id="registerFirstName" name="firstName"
                                value="<?php echo htmlspecialchars($firstName); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerLastName" class="form-label">Lastname</label>
                            <input type="text" class="form-control" id="registerLastName" name="lastName"
                                value="<?php echo htmlspecialchars($lastName); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="registerEmail" name="email"
                                value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPhoneNumber" class="form-label">Phone number</label>
                            <input type="text" class="form-control" id="registerPhoneNumber" name="phoneNumber"
                                value="<?php echo htmlspecialchars($phoneNumber); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="registerPassword" name="password" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-danger">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "./components/toasts.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function clearModal() {
            document.querySelector('.text-danger').innerHTML = '';
            document.querySelector('.text-success').innerHTML = '';
        }
        document.addEventListener('DOMContentLoaded', function() {
            const registerToast = document.getElementById('registerToast');
            const loginToast = document.getElementById('loginToast');

            <?php if ($registerError || $registerSuccess): ?>
                const toast = new bootstrap.Toast(registerToast);
                toast.show();
            <?php endif; ?>

            <?php if ($loginError): ?>
                const toast = new bootstrap.Toast(loginToast);
                toast.show();
            <?php endif; ?>
        });
    </script>

    <footer class="text-center mt-5 mb-3">
        <p>&copy; <?php echo date("Y"); ?> Project Approval System. All rights reserved.</p>
        <p>Developed by Rugwiro</p>
    </footer>
</body>

</html>
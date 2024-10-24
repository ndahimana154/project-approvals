<?php
include './php/connect.php';
include './mail_config.php'; // Include PHPMailer configuration
session_start();

$showResetModal = false;
$showOTPModal = false; // Used to display the OTP modal


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include("./components/outheader.php"); ?>
    <div class="container" style="margin-top:100px">
        <h2 class="mt-5">Admin/Supervisor Login</h2>

        <?php // Handle the login form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();

                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user'] = $user;
                        $_SESSION['user_name'] = $user['names'];
                        $_SESSION['role'] = $user['role'];

                        if ($user['role'] === 'admin') {
                            header("Location: ./admin/dashboard.php");
                        } elseif ($user['role'] === 'supervisor') {
                            header("Location: ./admin/dashboard.php");
                        }
                        exit();
                    } else {
                        $error = "Invalid password!";
                    }
                } else {
                    $error = "No user found with that email!";
                }
            }

            // Handle the "forgot password" form
            if (isset($_POST['forgot_password'])) {
                $email = $_POST['forgot_email'];

                // Check if the email exists
                $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    $userID = $user['id'];
                    $otp = rand(100000, 999999); // Generate a 6-digit OTP

                    // Insert OTP into the session table
                    $stmt = $conn->prepare("INSERT INTO session (userID, otp) VALUES (?, ?)");
                    $stmt->bind_param("ii", $userID, $otp);
                    $stmt->execute();

                    // Send OTP via PHPMailer
                    if (sendOTP($email, $otp)) {
                        $_SESSION['email'] = $email;
                        $showOTPModal = true; // Show OTP modal
                    } else {
                        $error = "Failed to send OTP! Please try again later.";
                    }
                } else {
                    $error = "No user found with that email!";
                }
            }

            // Handle OTP verification and password reset
            if (isset($_POST['otp']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
                $otp = $_POST['otp'];
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];

                if ($newPassword === $confirmPassword) {
                    // Verify OTP
                    $stmt = $conn->prepare("SELECT * FROM session WHERE otp = ? ORDER BY id DESC LIMIT 1");
                    $stmt->bind_param("i", $otp);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $sessionData = $result->fetch_assoc();
                        $userID = $sessionData['userID'];

                        // Hash the new password
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                        // Update the user's password
                        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                        $stmt->bind_param("si", $hashedPassword, $userID);
                        $stmt->execute();

                        // Optionally: Delete the used OTP from the session table
                        $stmt = $conn->prepare("DELETE FROM session WHERE userID = ?");
                        $stmt->bind_param("i", $userID);
                        $stmt->execute();

                        echo "<div class='alert alert-success'>Password successfully reset!</div>";
                        $showOTPModal = false; // Hide OTP modal
                    } else {
                        echo "<div class='alert alert-danger'>Invalid OTP!</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Passwords do not match!</div>";
                }
            }
        } ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <!-- Login Form -->
        <form method="POST" action="" class="w-50">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
            <a href="#" data-toggle="modal" data-target="#forgotPasswordModal" class="btn btn-link">Forgot Password?</a>
        </form>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="forgot_email">Enter your email:</label>
                            <input type="email" name="forgot_email" class="form-control" required>
                        </div>
                        <button type="submit" name="forgot_password" class="btn btn-primary">Send OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- OTP and Password Reset Modal -->
    <?php if ($showOTPModal) : ?>
        <div class="modal fade show" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true" style="display:block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="otp">Enter OTP:</label>
                                <input type="text" name="otp" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password:</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#resetPasswordModal').modal('show');
            });
        </script>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
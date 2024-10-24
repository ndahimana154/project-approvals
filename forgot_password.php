<?php
session_start();
include './php/connect.php';
include './mail_config.php'; // Include PHPMailer configuration

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php
    include("./components/outheader.php");

    ?>

    <div class="container" style="margin-top:100px">
        <h2 class="mt-5">Forgot Password</h2>
        <?php $showResetModal = false;
        if (isset($_GET['close'])) {
            $showResetModal = false;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['email'])) {
                $email = $_POST['email'];

                // Check if email exists in the students table
                $sql = "SELECT * FROM students WHERE email = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    $userID = $user['id'];
                    $otp = rand(100000, 999999);

                    $stmt = $conn->prepare("INSERT INTO session (userID, otp) VALUES (?, ?)");
                    $stmt->bind_param("ii", $userID, $otp);
                    $stmt->execute();

                    if (sendOTP($email, $otp)) {
                        $_SESSION['email'] = $email;
                        $showResetModal = true;
                    } else {
                        echo "<div class='alert alert-danger'>Failed to send OTP! Please try again later.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Email not found!</div>";
                }
            }

            if (isset($_POST['otp']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
                $otp = $_POST['otp'];
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];

                if ($newPassword === $confirmPassword) {
                    $sql = "SELECT * FROM session WHERE otp = '$otp' ORDER BY id DESC LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $sessionData = $result->fetch_assoc();
                        $userID = $sessionData['userID'];

                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                        $stmt = $conn->prepare("UPDATE students SET password = ? WHERE id = ?");
                        $stmt->bind_param("si", $hashedPassword, $userID);
                        $stmt->execute();

                        $stmt = $conn->prepare("DELETE FROM session WHERE userID = ?");
                        $stmt->bind_param("i", $userID);
                        $stmt->execute();

                        echo "<div class='alert alert-success'>Password successfully reset!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Invalid OTP!</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Passwords do not match!</div>";
                }
            }
        }
        ?>
        <form method="POST" action="" class="mt-4 w-50">
            <div class="form-group">
                <label for="email">Enter your email to reset password:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Send OTP</button>
        </form>
    </div>

    <?php if ($showResetModal) : ?>
        <div style="width: 100vw;height: 100vh;background: #00000070;position:fixed;top:0;left:0;z-index:3;">
            <div
                style="top:50%;left: 50%;position:absolute;transform:translate(-50%,-50%);
                width: 500px;"
                id="resetModal w-50" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true" style="display:block;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resetModalLabel">Reset Password</h5>
                            <a class="btn btn-danger" href="?close=1">
                                <i class="fa fa-close"></i>
                            </a>
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
        </div>
        <script>
            $(document).ready(function() {
                $('#resetModal').modal('show');
            });
        </script>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->
</body>

</html>
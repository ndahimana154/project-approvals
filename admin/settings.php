<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../php/connect.php";

// Check if user is logged in
if (!$_SESSION['user_id']) {
    header("Location:../index.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch current user information
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$userId'");
$user = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Project Approvals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../components/adminSidebar.php" ?>

            <div class="col-md-10">
                <div class="dashboard-header">
                    <h1 class="">Admin Dashboard</h1>
                </div>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);

                    $updateProfileQuery = "UPDATE users SET names = '$name', email = '$email' WHERE id = '$userId'";
                    if (mysqli_query($conn, $updateProfileQuery)) {
                        echo "<div class='alert alert-success'>Profile updated successfully!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error updating profile!</div>";
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
                    $currentPassword = $_POST['current_password'];
                    $newPassword = $_POST['new_password'];
                    $confirmPassword = $_POST['confirm_password'];

                    if (password_verify($currentPassword, $user['password'])) {
                        if ($newPassword == $confirmPassword) {
                            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                            $updatePasswordQuery = "UPDATE users SET password = '$hashedPassword' WHERE id = '$userId'";
                            if (mysqli_query($conn, $updatePasswordQuery)) {
                                echo "<div class='alert alert-success'>Password updated successfully!</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error updating password!</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>New passwords do not match!</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Current password is incorrect!</div>";
                    }
                } ?>
                <form method="POST" action="">
                    <h3>Update Profile Info</h3>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['names']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                </form>

                <hr>

                <form method="POST" action="">
                    <h3>Update Password</h3>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" name="update_password" class="btn btn-primary">Update Password</button>
                </form>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
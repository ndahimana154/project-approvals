<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../php/connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location:../index.php");
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM students WHERE id = $userId";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Database query failed: " . mysqli_error($conn);
    exit();
}

$student = mysqli_fetch_assoc($result);
if (!$student) {
    echo "No student found for this user ID.";
    exit();
}

// Check session for feedback messages
$toastMessage = "";
$toastType = "";
if (isset($_SESSION['toast_message'])) {
    $toastMessage = $_SESSION['toast_message'];
    $toastType = $_SESSION['toast_type'];
    unset($_SESSION['toast_message']); // Clear the message after using it
    unset($_SESSION['toast_type']); // Clear the type after using it
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Project approvals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <style>
        .container {
            margin-top: 50px;
        }

        .card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../components/studentsSidebar.php" ?>
            <div class="col-md-10">
                <div class="dashboard-header">
                    <h1 class="">Settings</h1>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card p-4 mb-4">
                            <h2>Personal Information</h2>
                            <form action="update_personal_info.php" method="POST" enctype="multipart/form-data">
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($student['firstname']); ?>" required>
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($student['lastname']); ?>" required>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required>
                                </div>

                                <!-- Registration Number -->
                                <div class="mb-3">
                                    <label for="regno" class="form-label">Registration Number</label>
                                    <input type="text" class="form-control" id="regno" name="regno" value="<?php echo htmlspecialchars($student['regno']); ?>">
                                </div>

                                <!-- Class -->
                                <div class="mb-3">
                                    <label for="class" class="form-label">Class</label>
                                    <input type="text" class="form-control" id="class" name="class" value="<?php echo htmlspecialchars($student['class']); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Save Personal Info</button>
                            </form>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="col-md-6">
                        <div class="card p-4 mb-4">
                            <h2>Change Password</h2>
                            <form action="update_password.php" method="POST">
                                <!-- Old Password -->
                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="old_password" name="old_password" required>
                                </div>

                                <!-- New Password -->
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>

                                <!-- Confirm New Password -->
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <?php if ($toastMessage): ?>
            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
                <div class="toast-header">
                    <strong class="me-auto"><?php echo $toastType === 'success' ? 'Success!' : 'Error!'; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <?php echo $toastMessage; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>
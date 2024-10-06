<?php
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
?>
<div class="col-md-2 sidebar">
    <div class="profile-section">
        <img src="../assets/images/user.png" alt="Profile Image" class="profile-img">
        <div>
            <h5>
                <?php
                $email = $_SESSION['user']['email'];
                $email_parts = explode('@', $email);
                $username = $email_parts[0];
                echo $username;
                ?>
            </h5>
        </div>
    </div>
    <hr>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_project.php">Add project</a>
    <a href="view_projects.php">Project List</a>
    <a href="settings.php">Settings</a>
    <a href="../php/logout.php" class="logout bg-danger" style="border-radius: 8px; padding: 10px; color: white; text-decoration: none;">
        <i class="fa fa-sign-out" style="margin-right: 5px;"></i>
        Logout
    </a>

</div>
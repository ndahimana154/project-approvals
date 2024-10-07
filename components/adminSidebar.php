<?php
$userId = $_SESSION['user_id'];
$user = $_SESSION['user']

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
    <?php
    if ($user["role"] === 'admin') {
    ?>
        <a href="projects_list.php">Project List</a>
        <a href="new_supervisor.php">New supervisor</a>
        <a href="supervisors_list.php">Supervisors</a>
        <a href="assignSupervisor.php">Supervisors assignment</a>
    <?php
    } else {
    ?>
        <a href="supervisors_projects_list.php">Projects list</a>
    <?php
    }
    ?>

    <a href="settings.php">Settings</a>
    <a href="../php/logout.php" class="logout bg-danger" style="border-radius: 8px; padding: 10px; color: white; text-decoration: none;">
        <i class="fa fa-sign-out" style="margin-right: 5px;"></i>
        Logout
    </a>

</div>
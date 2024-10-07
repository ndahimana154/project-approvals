<?php
$userId = $_SESSION['user_id'];
$user = $_SESSION['user'];
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
    <a href="dashboard.php">
        <i class="fa fa-tachometer-alt"></i> Dashboard
    </a>
    <?php
    if ($user["role"] === 'admin') {
    ?>
        <a href="projects_list.php">
            <i class="fa fa-list"></i> Project List
        </a>
        <a href="new_supervisor.php">
            <i class="fa fa-user-plus"></i> New Supervisor
        </a>
        <a href="supervisors_list.php">
            <i class="fa fa-users"></i> Supervisors
        </a>
        <a href="assignSupervisor.php">
            <i class="fa fa-user-tag"></i> Supervisor Assignment
        </a>
    <?php
    } else {
    ?>
        <a href="supervisors_projects_list.php">
            <i class="fa fa-project-diagram"></i> Projects List
        </a>
    <?php
    }
    ?>
    <a href="settings.php">
        <i class="fa fa-cog"></i> Settings
    </a>
    <a href="../php/logout.php" class="logout bg-danger" style="border-radius: 8px; padding: 10px; color: white; text-decoration: none;">
        <i class="fa fa-sign-out-alt" style="margin-right: 5px;"></i> Logout
    </a>
</div>
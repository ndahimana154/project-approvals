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
    <a href="view_projects.php">View Projects</a>
    <a href="project_list.php">Project List</a>
    <a href="settings.php">Settings</a>
    <a href="../php/logout.php" class="text-danger">Logout</a>
</div>
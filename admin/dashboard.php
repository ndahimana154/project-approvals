<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../php/connect.php";

if (!$_SESSION['user_id']) {
    header("Location:../index.php");
    exit();
}

$userId = $_SESSION['user_id'];
$user = $_SESSION['user'];

$totalProjectsQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_projects FROM studentsProjects");
$totalProjects = mysqli_fetch_assoc($totalProjectsQuery)['total_projects'];

$totalStudentsQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_students FROM students");
$totalStudents = mysqli_fetch_assoc($totalStudentsQuery)['total_students'];

$pendingProjectsQuery = mysqli_query($conn, "SELECT COUNT(*) AS pending_projects FROM studentsProjects WHERE status = 'pending'");
$pendingProjects = mysqli_fetch_assoc($pendingProjectsQuery)['pending_projects'];

$totalSystemUsersQuery = mysqli_query($conn, "SELECT COUNT(*) AS totalusers FROM users");
$totalSystemUsers = mysqli_fetch_assoc($totalSystemUsersQuery)['totalusers'];


$totalProjectsAssignedQuery = mysqli_query($conn, "SELECT COUNT(*) AS totalProjects FROM supervisor_project_assignment WHERE supervisor_id = '$userId'");
$totalAssignedProjects = mysqli_fetch_assoc($totalProjectsAssignedQuery)['totalProjects'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Project Approvals</title>
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
                    <h1 class="">Dashboard</h1>
                </div>

                <div class="container mt-4">
                    <div class="row">
                        <?php
                        if ($user["role"] === 'admin') {
                        ?>
                            <div class="col-md-3">
                                <a href="projects_list.php">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Projects</h5>
                                            <p class="card-text">
                                                <strong><?php echo $totalProjects; ?></strong>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="projects_list.php">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Pending Projects</h5>
                                            <p class="card-text">
                                                <strong><?php echo $pendingProjects; ?></strong>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="students_list.php">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Students</h5>
                                            <p class="card-text">
                                                <strong><?php echo $totalStudents; ?></strong>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="supervisors_list.php">
                                    <div class="card bg-danger text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">System users</h5>
                                            <p class="card-text">
                                                <strong>
                                                    <?php echo $totalSystemUsers - 1 ?>
                                                </strong>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-md-3">
                                <a href="./supervisors_projects_list.php">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Assigned projects</h5>
                                            <p class="card-text">
                                                <strong><?php echo $totalAssignedProjects; ?></strong>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
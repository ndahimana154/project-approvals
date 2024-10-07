<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../php/connect.php";
if (!$_SESSION['user_id']) {
    header("Location: ../index.php");
    exit();
}
$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Project Approvals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../components/studentsSidebar.php"; ?>
            <div class="col-md-10">
                <div class="dashboard-header">
                    <h1 class="my-4">Student Dashboard</h1>
                </div>
                <div class="container">
                    <div class="row">
                        <!-- Projects Summary Section -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <?php
                                            $sql = mysqli_query($conn, "SELECT * FROM studentsProjects WHERE student_id = $userId");
                                            $totalProjects = mysqli_num_rows($sql);
                                            ?>
                                            <h5 class="card-title">Total Projects Submitted</h5>
                                            <p class="card-text">You have submitted <strong><?php echo $totalProjects; ?></strong> projects.</p>
                                            <a href="view_projects.php" class="btn btn-primary">View Projects</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Additional Info Section -->
                                <div class="col-md-6 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Other Information</h5>
                                            <p class="card-text">Add important details here.</p>
                                            <a href="#" class="btn btn-primary">Action</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Optional Section -->
                                <div class="col-md-12 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">More Info</h5>
                                            <p class="card-text">You can display more details here if needed.</p>
                                            <a href="#" class="btn btn-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Members Section -->
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Recent Members</h5>
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        $sql = "
                                            SELECT students.firstname, students.lastname, studentsProjects.title 
                                            FROM project_members 
                                            JOIN students ON project_members.student_id = students.id 
                                            JOIN studentsProjects ON project_members.project_id = studentsProjects.id 
                                            WHERE studentsProjects.student_id = $userId
                                        ";
                                        $result = mysqli_query($conn, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<li class='list-group-item'>";
                                                echo "<strong>Project:</strong> " . htmlspecialchars($row['title']) . "<br>";
                                                echo "<strong>Member:</strong> " . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']);
                                                echo "</li>";
                                            }
                                        } else {
                                            echo "<li class='list-group-item'>No members found for your projects.</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
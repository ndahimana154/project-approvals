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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../components/studentsSidebar.php" ?>
            <div class="col-md-10">
                <div class="dashboard-header">
                    <h1 class="">Student's dashboard</h1>
                </div>
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM  studentsProjects WHERE student_id = $userId");
                                    ?>
                                    <h5 class="card-title">Total Projects Submitted</h5>
                                    <p class="card-text">You have submitted <strong>
                                            <?php echo mysqli_num_rows($sql) ?>
                                        </strong> projects recently.</p>
                                    <a href="view_projects.php" class="btn btn-primary">View Projects</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Recent members</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">Feature 1</li>
                                        <li class="list-group-item">Feature 2</li>
                                        <li class="list-group-item">Feature 3</li>
                                        <li class="list-group-item">Feature 4</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Another Card Title</h5>
                                    <p class="card-text">Some other important information can go here.</p>
                                    <a href="#" class="btn btn-primary">Action</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Additional Information</h5>
                                    <p class="card-text">You can place any relevant information here.</p>
                                    <a href="#" class="btn btn-primary">Action</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-Ksv6CTTT9Y+Y9vEdhbnc/kolc5B9k0SkOvR6aUkhhPj2HptP0V3sCVZlAlC1Omp"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
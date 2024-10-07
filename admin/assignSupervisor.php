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
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supervisorId = $_POST['supervisor_id'];
    $projectId = $_POST['project_id'];

    $checkQuery = "SELECT * FROM supervisor_project_assignment WHERE supervisor_id = '$supervisorId' AND project_id = '$projectId'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $message = 'This supervisor is already assigned to this project.';
    } else {
        $insertQuery = "INSERT INTO supervisor_project_assignment (supervisor_id, project_id) VALUES ('$supervisorId', '$projectId')";
        if (mysqli_query($conn, $insertQuery)) {
            $message = 'Supervisor assigned to the project successfully.';
        } else {
            $message = 'Error: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Supervisor - Project approvals</title>
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
                    <h1>Assign Supervisor to Project</h1>
                </div>
                <div class="container mt-4">
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-info">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="supervisor_id" class="form-label">Select Supervisor</label>
                            <select class="form-control" id="supervisor_id" name="supervisor_id" required>
                                <option value="">-- Select Supervisor --</option>
                                <?php
                                $supervisors = mysqli_query($conn, "SELECT * FROM users WHERE role = 'supervisor'");
                                while ($supervisor = mysqli_fetch_assoc($supervisors)) {
                                    echo "<option value='" . $supervisor['id'] . "'>" . $supervisor['names'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="project_id" class="form-label">Select Project</label>
                            <select class="form-control" id="project_id" name="project_id" required>
                                <option value="">-- Select Project --</option>
                                <?php
                                $projects = mysqli_query($conn, "SELECT * FROM studentsprojects");
                                while ($project = mysqli_fetch_assoc($projects)) {
                                    echo "<option value='" . $project['id'] . "'>" . $project['title'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign Supervisor</button>
                    </form>
                </div>

                <div class="container mt-5">
                    <h2>Current Assignments</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Supervisor</th>
                                <th>Project</th>
                                <th>Assigned Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $assignments = mysqli_query($conn, "SELECT a.id, u.names as supervisor, p.title as project, a.assigned_date 
                                                                FROM supervisor_project_assignment a 
                                                                JOIN users u ON a.supervisor_id = u.id 
                                                                JOIN studentsprojects p ON a.project_id = p.id
                                                                ORDER BY a.assigned_date DESC");
                            if (mysqli_num_rows($assignments) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($assignments)) {
                                    echo "<tr>";
                                    echo "<td>" . $count++ . "</td>";
                                    echo "<td>" . $row['supervisor'] . "</td>";
                                    echo "<td>" . $row['project'] . "</td>";
                                    echo "<td>" . $row['assigned_date'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No assignments found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
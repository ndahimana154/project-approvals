<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../php/connect.php";

if (!$_SESSION['user_id']) {
    header("Location:../index.php");
    exit();
}

$projectId = $_GET['project_id'];

$sql = "
    SELECT pm.id, s.firstname, s.lastname, s.email, pm.role, p.title 
    FROM project_members pm 
    JOIN students s ON pm.student_id = s.id 
    JOIN studentsProjects p ON pm.project_id = p.id 
    WHERE pm.project_id = $projectId
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project members list</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../components/studentsSidebar.php" ?>

            <div class="col-md-10">
                <div class="dashboard-header">
                    <h1 class="">Project members list</h1>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project title</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['title']) . "</td>"; // Display project title
                                echo "<td>" . htmlspecialchars($row['firstname'] . " " . $row['lastname']) . "</td>"; // Display student name
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No members found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="view_projects.php" class="btn btn-primary">Back to Projects</a>
            </div>
        </div>
    </div>
</body>

</html>

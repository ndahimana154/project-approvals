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

$sql = "SELECT * FROM studentsProjects WHERE student_id = $userId";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Submitted Projects</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Your Submitted Projects</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>File</th>
                    <th>Date Submitted</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>";
                        if ($row['file_name']) {
                            echo "<a href='../uploads/" . htmlspecialchars($row['file_name']) . "'>Download</a>";
                        } else {
                            echo "No file uploaded";
                        }
                        echo "</td>";
                        echo "<td>" . $row['created_at'] . "</td>"; // Make sure to have a 'created_at' column in your database if you want to display submission date
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No projects submitted yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="add_project.php" class="btn btn-primary">Add New Project</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

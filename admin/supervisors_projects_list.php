<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../php/connect.php";

// Redirect to login if user is not logged in
if (!$_SESSION['user_id']) {
    header("Location:../index.php");
    exit();
}

$userId = $_SESSION['user_id']; // Get the supervisor's user ID from the session

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Projects - Supervisor View</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../components/adminSidebar.php"; ?>
            <div class="col-md-10">
                <div class="dashboard-header">
                    <h1>Assigned Projects</h1>
                </div>
                <div class="container mt-4">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Project Title</th>
                                <th>Project Description</th>
                                <th>Student</th>
                                <th>Status</th>
                                <th>Assigned Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT sp.id, sp.title,sp.description, sp.status, spa.assigned_date, 
                                      s.firstname, s.lastname
                                      FROM studentsProjects sp
                                      JOIN students s ON sp.student_id = s.id
                                      JOIN supervisor_project_assignment spa ON sp.id = spa.project_id
                                      WHERE spa.supervisor_id = '$userId'
                                      ORDER BY spa.assigned_date DESC;";

                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $count++ . "</td>";
                                    echo "<td>" . $row['title'] . "</td>";
                                    echo "<td>" . $row['description'] . "</td>";
                                    echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                                    echo "<td>" . ucfirst($row['status']) . "</td>";
                                    echo "<td>" . $row['assigned_date'] . "</td>";
                            ?>
                                    <td>
                                        <a href="viewproject_progress.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">View progress</a>

                                    </td>
                            <?php
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan='6'>No assigned projects found.</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Action completed successfully.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
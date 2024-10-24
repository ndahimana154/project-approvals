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

if (isset($_GET['action']) && $_GET['action'] == 'reject' && isset($_GET['project_id'])) {
    $projectId = $_GET['project_id'];
    $query = "UPDATE studentsprojects SET status = 'Rejected' WHERE id = '$projectId'";
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Project rejected successfully.');
                window.location.href = window.location.pathname; // Reload the page without parameters
              </script>";
    } else {
        echo "<script>
                alert('Failed to reject the project.');
                window.location.href = window.location.pathname; // Reload the page without parameters
              </script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'accept' && isset($_GET['project_id'])) {
    $projectId = $_GET['project_id'];
    $query = "UPDATE studentsprojects SET status = 'Accepted' WHERE id = '$projectId'";
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Project accepted successfully.');
                window.location.href = window.location.pathname; // Reload the page without parameters
              </script>";
    } else {
        echo "<script>
                alert('Failed to accept the project.');
                window.location.href = window.location.pathname; // Reload the page without parameters
              </script>";
    }
}

function formatDate($date)
{
    $dateTime = new DateTime($date);

    $day = $dateTime->format('j');
    if ($day == 1 || $day == 21 || $day == 31) {
        $daySuffix = 'st';
    } elseif ($day == 2 || $day == 22) {
        $daySuffix = 'nd';
    } elseif ($day == 3 || $day == 23) {
        $daySuffix = 'rd';
    } else {
        $daySuffix = 'th';
    }

    $month = strtolower($dateTime->format('m'));

    $year = substr($dateTime->format('Y'), -3);

    $hours = $dateTime->format('H');
    $minutes = $dateTime->format('i');

    return $day . $daySuffix . '.' . $month . '.' . $year . ' ' . $hours . 'h:' . $minutes;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects list - Project approvals</title>
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
                    <h1 class="">Projects list</h1>
                </div>
                <div class="container mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Project Owner</th>
                                <th>Project file</th>
                                <th>Other members</th>
                                <th>Submitted at</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT *,studentsprojects.id as id FROM studentsprojects,students 
                                WHERE students.id = studentsprojects.student_id
                                ORDER BY studentsprojects.created_at DESC");
                            if (mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $count++ . "</td>";
                                    echo "<td>" . $row['title'] . "</td>";
                                    echo "<td>" . $row['description'] . "</td>";
                                    echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                            ?>
                                    <td>
                                        <a href="../assets/projects/<?php echo $row['file_name']; ?>">Download</a>
                                    </td>
                                    <td>
                                        <?php
                                        $membersResult = mysqli_query($conn, "SELECT * FROM project_members,students WHERE project_id ='" . $row['id'] . "' AND project_members.student_id = students.id");
                                        if (mysqli_num_rows($membersResult) > 0) {
                                            while ($membersCount = mysqli_fetch_assoc($membersResult)) {
                                                echo $membersCount["firstname"] . " " . $membersCount["lastname"] . ", ";
                                            }
                                        } else {
                                            echo "No other members";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    echo "<td>" . formatDate($row['created_at']) . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    ?>
                                    <td>
                                        <?php
                                        if ($row['status'] === 'pending') {
                                        ?>
                                            <a href="?action=reject&project_id=<?php echo $row['id']; ?>" class="btn btn-danger">Reject</a>
                                            <a href="?action=accept&project_id=<?php echo $row['id']; ?>" class="btn btn-success">Accept</a>
                                        <?php
                                        }
                                        ?>
                                        <a href="viewproject_progress.php?project_id=<?php echo $row['id']; ?>" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#assignModal<?php echo $row['id']; ?>">Track progress</a>
                                    </td>
                                <?php
                                    echo "</tr>";
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="70">No projects found.</td>
                                </tr>
                            <?php
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

    <?php
    $result = mysqli_query($conn, "SELECT *,studentsprojects.id as id FROM studentsprojects,students WHERE students.id = studentsprojects.student_id");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
            <div class="modal fade" id="assignModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="assignModalLabel">Assign Supervisor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Assign a supervisor for the project titled "<?php echo $row['title']; ?>".
                            <form action="assign_supervisor.php" method="POST">
                                <input type="hidden" name="project_id" value="<?php echo $row['id']; ?>">
                                <div class="mb-3">
                                    <label for="supervisor" class="form-label">Select Supervisor</label>
                                    <select class="form-select" name="supervisor_id" id="supervisor" required>
                                        <?php
                                        $supervisors = mysqli_query($conn, "SELECT id, firstname, lastname FROM supervisors");
                                        while ($supervisor = mysqli_fetch_assoc($supervisors)) {
                                            echo "<option value='" . $supervisor['id'] . "'>" . $supervisor['firstname'] . " " . $supervisor['lastname'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning">Assign Supervisor</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
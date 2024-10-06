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

$sql = "
    SELECT sp.*, COUNT(pm.id) AS member_count 
    FROM studentsProjects AS sp
    LEFT JOIN project_members AS pm ON sp.id = pm.project_id
    WHERE sp.student_id = $userId
    GROUP BY sp.id";
$result = mysqli_query($conn, $sql);
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
            <?php include "../components/studentsSidebar.php" ?>

            <div class="col-md-10">
                <div class="dashboard-header">
                    <h1 class="">Projects list</h1>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Members</th>
                            <th>Date Submitted</th>
                            <th>Actions</th>
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
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>";
                                if ($row['file_name']) {
                                    echo "<a href='../assets/projects/" . htmlspecialchars($row['file_name']) . "'>Download</a>";
                                } else {
                                    echo "No file uploaded";
                                }
                                echo "</td>";
                                echo "<td>" . $row['member_count'] . "</td>";
                                echo "<td>" . $row['created_at'] . "</td>";
                        ?>
                                <td>
                                    <a href="add_project_member.php?project_id=<?php echo $row['id']; ?>"
                                        title="Add project member"
                                        class="action_button bg-success">
                                        <i class="fa fa-plus-circle"></i>
                                    </a>
                                    <a href="view_project_members.php?project_id=<?php echo $row['id']; ?>"
                                        title="View Project Members"
                                        class="action_button bg-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>

                        <?php
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No projects submitted yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add_project.php" class="btn btn-primary">Add New Project</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
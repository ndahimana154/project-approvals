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
    <title>Student Dashboard - Project approvals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                <div class="container mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Title
                                </th>
                                <th>
                                    Description
                                </th>
                                <th>
                                    Members
                                </th>
                                <th>
                                    Supervisors
                                </th>
                                <th>
                                    Submitted at
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * from studentsprojects WHERE student_id ='$userId' ORDER BY created_at DESC");
                            if (mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $count++ . "</td>";
                                    echo "<td>" . $row['title'] . "</td>";
                                    echo "<td>" . $row['description'] . "</td>";
                            ?>
                                    <td>
                                        <?php
                                        $membersResult = mysqli_query($conn, "SELECT * FROM project_members,students WHERE project_id ='" . $row['id'] . "' AND project_members.student_id = students.id");
                                        if (mysqli_num_rows($membersResult) > 0) {
                                            while ($membersCount = mysqli_fetch_assoc($membersResult)) {
                                                echo $membersCount["firstname"] . " " . $membersCount["lastname"] . ", ";
                                            }
                                        } else {
                                            echo "No members found.";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $supervisorsResult = mysqli_query($conn, "SELECT * FROM supervisor_project_assignment WHERE project_id ='" . $row['id'] . "'");
                                        if (mysqli_num_rows($supervisorsResult) > 0) {

                                            while ($supervisorCount = mysqli_fetch_assoc($supervisorsResult)) {
                                                $supervisorId = $supervisorCount['supervisor_id'];
                                                $supervisorResult = mysqli_query($conn, "SELECT * FROM users WHERE id = '$supervisorId'");
                                                $supervisorRow = mysqli_fetch_assoc($supervisorResult);
                                                echo $supervisorRow['names'] . ", ";
                                            }
                                        } else {
                                            echo "No supervisor yet";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    ?>
                                    <td>
                                        <a href='../assets/projects/" . urlencode($row["file_name"]) . "' class='action_button btn btn-primary' download>
                                            <i class='fa fa-download'></i>
                                        </a>

                                        <a href=" add_project_member.php?project_id=<?php echo $row['id']; ?>"
                                            title="Add project member"
                                            class="action_button btn btn-success">
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                        <a href="track_progress.php?project_id=<?php echo $row['id']; ?>" class="btn btn-info">Track Progress</a>
                                    </td>
                            <?php
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-Ksv6CTTT9Y+Y9vEdhbnc/kolc5B9k0SkOvR6aUkhhPj2HptP0V3sCVZlAlC1Omp"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
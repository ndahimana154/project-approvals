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
    <title>Students list - Project approvals</title>
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
                    <h1 class="">Students list</h1>
                </div>
                <div class="container mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Names</th>
                                <th>Regno</th>
                                <th>email</th>
                                <th>phone number</th>
                                <th>class</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * from students order by firstname ASC");
                            if (mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $count++ . "</td>";
                                    echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                                    echo "<td>" . $row['regno'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>" . $row['class'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="70">No supervisors found.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
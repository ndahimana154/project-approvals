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
    <title>Track Project Progress</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">

    <script>
        function printProgress() {
            var printWindow = window.open('', '_blank', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Progress History</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h1>Progress History</h1>');
            printWindow.document.write(document.getElementById('progressHistory').innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include "../components/adminSidebar.php"; ?>

            <div class="col-md-10 p-4">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-0">Track Project Progress</h1>
                        <div>
                            <button class="btn btn-outline-success" onclick="printProgress()">
                                <i class="fa fa-print"></i> Print Progress
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="mb-4">Progress History</h3>
                        <ul class="list-group" id="progressHistory">
                            <?php
                            $projectId = $_GET['project_id'];
                            $progressSql = "SELECT * FROM project_progress WHERE project_id = '$projectId' ORDER BY created_at DESC";
                            $progressResult = mysqli_query($conn, $progressSql);

                            if (mysqli_num_rows($progressResult) > 0) {
                                while ($row = mysqli_fetch_assoc($progressResult)) {
                                    echo "<li class='list-group-item mb-3'>";
                                    echo "<div class='d-flex justify-content-between align-items-start'>";
                                    echo "<div>";
                                    echo "<strong>Date:</strong> " . $row['created_at'] . "<br>";
                                    echo "<strong>Progress:</strong> " . htmlspecialchars($row['progress_text']) . "<br>";
                                    if ($row['screenshot']) {
                                        echo "<strong>Screenshot:</strong><br> <img src='../assets/project_progress/" . htmlspecialchars($row['screenshot']) . "' alt='Screenshot' class='img-thumbnail' width='150'><br>";
                                    }
                                    if ($row['comment_file']) {
                                        echo "<strong>Uploaded File:</strong><br><a href='" . htmlspecialchars($row['comment_file']) . "' target='_blank' download>Download file</a><br>";
                                    }
                                    echo "<strong>Supervisor's Comment:</strong> " . htmlspecialchars($row['supervisor_comment']);
                                    echo "</div>";
                                    echo "</div>";

                                    // Form for adding supervisor comments and file upload
                                    echo "<form action='' method='POST' enctype='multipart/form-data' class='mt-3'>";
                                    echo "<input type='hidden' name='progress_id' value='" . $row['id'] . "'>";
                                    echo "<div class='mb-3'>";
                                    echo "<label for='supervisor_comment_" . $row['id'] . "' class='form-label'>Add Comment</label>";
                                    echo "<textarea class='form-control' id='supervisor_comment_" . $row['id'] . "' name='supervisor_comment' rows='2'>" . htmlspecialchars($row['supervisor_comment']) . "</textarea>";
                                    echo "</div>";
                                    echo "<div class='mb-3'>";
                                    echo "<label for='file_" . $row['id'] . "' class='form-label'>Attach File</label>";
                                    echo "<input type='file' class='form-control' id='file_" . $row['id'] . "' name='comment_file'>";
                                    echo "</div>";
                                    echo "<button type='submit' class='btn btn-primary'>Submit Comment</button>";
                                    echo "</form>";

                                    // Handle the comment and file submission
                                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supervisor_comment']) && isset($_POST['progress_id'])) {
                                        $supervisorComment = mysqli_real_escape_string($conn, $_POST['supervisor_comment']);
                                        $progressId = $_POST['progress_id'];

                                        $uploadDir = '../assets/project_files/'; // Directory where files will be uploaded
                                        $filePath = '';

                                        // Check if a file is uploaded
                                        if (isset($_FILES['comment_file']) && $_FILES['comment_file']['error'] == 0) {
                                            $fileName = basename($_FILES['comment_file']['name']);
                                            $filePath = $uploadDir . time() . "_" . $fileName; // Create a unique filename

                                            // Move uploaded file to the target directory
                                            if (move_uploaded_file($_FILES['comment_file']['tmp_name'], $filePath)) {
                                                $filePath = mysqli_real_escape_string($conn, $filePath); // Escape for database
                                            } else {
                                                echo "<p class='alert alert-danger mt-2'>File upload failed.</p>";
                                            }
                                        }

                                        // Update the database with the supervisor's comment and file path (if any)
                                        $commentSql = "UPDATE project_progress SET supervisor_comment='$supervisorComment'";
                                        if ($filePath) {
                                            $commentSql .= ", comment_file='$filePath'";
                                        }
                                        $commentSql .= " WHERE id='$progressId'";

                                        if (mysqli_query($conn, $commentSql)) {
                                            echo "<p class='alert alert-success mt-2'>Comment and file added successfully.</p>";
                                        } else {
                                            echo "<p class='alert alert-danger mt-2'>Comment addition failed: " . mysqli_error($conn) . "</p>";
                                        }
                                    }
                                    echo "</li>";
                                }
                            } else {
                                echo "<li class='list-group-item'>No progress updates yet.</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
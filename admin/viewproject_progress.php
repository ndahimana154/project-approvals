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
$projectId = $_GET['project_id'];

// Handle form submission and file uploads
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
            $_SESSION['upload_message'] = [
                'text' => 'File upload failed.',
                'class' => 'alert-danger'
            ];
            header("Location: " . $_SERVER['PHP_SELF'] . "?project_id=" . $projectId);
            exit();
        }
    }

    // Update the database with the supervisor's comment and file path (if any)
    $commentSql = "UPDATE project_progress SET supervisor_comment='$supervisorComment'";
    if ($filePath) {
        $commentSql .= ", comment_file='$filePath'";
    }
    $commentSql .= " WHERE id='$progressId'";

    if (mysqli_query($conn, $commentSql)) {
        $_SESSION['upload_message'] = [
            'text' => 'Comment and file added successfully.',
            'class' => 'alert-success'
        ];
    } else {
        $_SESSION['upload_message'] = [
            'text' => 'Comment addition failed: ' . mysqli_error($conn),
            'class' => 'alert-danger'
        ];
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?project_id=" . $projectId);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project progress - Project approvals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
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
                        <div class="container mt-3">
                            <?php if (isset($_SESSION['upload_message'])) : ?>
                                <div class="alert <?php echo $_SESSION['upload_message']['class']; ?>" role="alert">
                                    <?php echo $_SESSION['upload_message']['text']; ?>
                                </div>
                                <?php unset($_SESSION['upload_message']); ?>
                            <?php endif; ?>
                        </div>
                        <ul class="list-group" id="progressHistory">
                            <?php
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
                                        echo "<strong>File:</strong><br> ";
                            ?>
                                        <a href="../assets/project_progress/<?php echo $row['screenshot']; ?>" alt='Image' class="btn btn-success" download>Download</a> <br>
                            <?php }
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
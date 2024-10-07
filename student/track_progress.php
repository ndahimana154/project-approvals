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
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../components/studentsSidebar.php" ?>
            <div class="col-md-10">
                <div class="dashboard-header">
                    <h1 class="">Track progress</h1>
                </div>
                <?php

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $projectId = $_POST['project_id'];
                    $progressText = mysqli_real_escape_string($conn, $_POST['progress_text']);

                    $screenshot = '';
                    if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == UPLOAD_ERR_OK) {
                        $fileTmpPath = $_FILES['screenshot']['tmp_name'];
                        $fileName = $_FILES['screenshot']['name'];
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                        $uniqueName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $fileExtension;

                        $destination = "../assets/project_progress/" . $uniqueName;

                        move_uploaded_file($fileTmpPath, $destination);

                        $screenshot = $uniqueName;
                    }

                    $sql = "INSERT INTO project_progress (project_id, student_id, progress_text, screenshot)
        VALUES ('$projectId', '$userId', '$progressText', '$screenshot')";

                    if (mysqli_query($conn, $sql)) {
                ?>
                        <p class="alert alert-success">
                            progress added successfully.
                        </p>
                    <?php
                    } else {
                    ?>
                        Progress recording failed.
                <?php
                    }
                }
                ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="progress_text" class="form-label">Progress Update</label>
                        <textarea class="form-control" id="progress_text" name="progress_text" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="screenshot" class="form-label">Upload Screenshot (optional)</label>
                        <input type="file" class="form-control" id="screenshot" name="screenshot" accept="image/*">
                    </div>
                    <input type="hidden" name="project_id" value="<?php echo $_GET['project_id']; ?>">
                    <button type="submit" class="btn btn-primary">Submit Progress</button>
                </form>

                <hr>
                <h3>Progress History</h3>
                <ul class="list-group">
                    <?php
                    $projectId = $_GET['project_id'];
                    $progressSql = "SELECT * FROM project_progress WHERE project_id = '$projectId' ORDER BY created_at DESC";
                    $progressResult = mysqli_query($conn, $progressSql);

                    if (mysqli_num_rows($progressResult) > 0) {
                        while ($row = mysqli_fetch_assoc($progressResult)) {
                            echo "<li class='list-group-item'>";
                            echo "<strong>Date:</strong> " . $row['created_at'] . "<br>";
                            echo "<strong>Progress:</strong> " . htmlspecialchars($row['progress_text']) . "<br>";
                            if ($row['screenshot']) {
                                echo "<strong>Screenshot:</strong> <img src='../assets/project_progress/" . htmlspecialchars($row['screenshot']) . "' alt='Screenshot' width='100'><br>";
                            }
                            echo "<strong>Supervisor's Comment:</strong> " . htmlspecialchars($row['supervisor_comment']);
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
</body>

</html>
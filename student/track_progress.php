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
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../components/studentsSidebar.php" ?>
            <div class="col-md-10">
                <div class="dashboard-header py-4">
                    <h1 class="text-primary">Track Project Progress</h1>
                </div>
                
                <!-- Success/Error Messages -->
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $projectId = $_POST['project_id'];
                    $progressText = mysqli_real_escape_string($conn, $_POST['progress_text']);

                    // Handle file upload
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
                        <div class="alert alert-success">
                            Progress added successfully.
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-danger">Progress recording failed. Please try again.</div>
                <?php
                    }
                }
                ?>

                <!-- Progress Form -->
                <form action="" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded-3 shadow-sm">
                    <div class="mb-3">
                        <label for="progress_text" class="form-label">Progress Update</label>
                        <textarea class="form-control" id="progress_text" name="progress_text" rows="3" required placeholder="Describe your progress..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="screenshot" class="form-label">Upload Screenshot (optional)</label>
                        <input type="file" class="form-control" id="screenshot" name="screenshot" accept="image/*">
                    </div>
                    <input type="hidden" name="project_id" value="<?php echo $_GET['project_id']; ?>">
                    <button type="submit" class="btn btn-primary">Submit Progress</button>
                </form>

                <hr>

                <!-- Progress History Section -->
                <h3 class="mt-5">Progress History</h3>
                <ul class="list-group mb-4">
                    <?php
                    $projectId = $_GET['project_id'];
                    $progressSql = "SELECT * FROM project_progress WHERE project_id = '$projectId' ORDER BY created_at DESC";
                    $progressResult = mysqli_query($conn, $progressSql);

                    if (mysqli_num_rows($progressResult) > 0) {
                        while ($row = mysqli_fetch_assoc($progressResult)) {
                            echo "<li class='list-group-item d-flex flex-column'>";
                            echo "<strong>Date:</strong> " . date('F j, Y, g:i a', strtotime($row['created_at'])) . "<br>";
                            echo "<strong>Progress:</strong> " . htmlspecialchars($row['progress_text']) . "<br>";
                            
                            if ($row['screenshot']) {
                                echo "<strong>Screenshot:</strong><br>";
                                echo "<img src='../assets/project_progress/" . htmlspecialchars($row['screenshot']) . "' alt='Screenshot' class='img-thumbnail my-2' width='150'><br>";
                            }

                            // Display supervisor comment and file if available
                            echo "<strong>Supervisor's Comment:</strong> " . (empty($row['supervisor_comment']) ? "No comment yet." : htmlspecialchars($row['supervisor_comment']));
                            if ($row['comment_file']) {
                                echo "<br><strong>Commented File:</strong> <a href='../assets/project_progress/" . htmlspecialchars($row['comment_file']) . "' download class='btn btn-outline-primary'>Download</a>";
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
</body>

</html>

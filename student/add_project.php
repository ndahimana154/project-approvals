<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../php/connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location:../index.php");
    exit();
}

$userId = $_SESSION['user_id'];

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $checkSql = "SELECT * FROM studentsProjects WHERE title = '$title' AND student_id = '$userId'";
    $result = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($result) > 0) {
        $message = "Error: A project with this title already exists!";
    } else {
        $file_name = '';
        if (isset($_FILES['file_name']) && $_FILES['file_name']['error'] == 0) {
            $target_dir = "../assets/projects/";
            $uniqueId = uniqid('', true); // Generates a unique ID
            $file_name = $uniqueId . "_" . basename($_FILES['file_name']['name']);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($_FILES['file_name']['tmp_name'], $target_file)) {
            } else {
                $message = "Error uploading the file.";
            }
        }

        $sql = "INSERT INTO studentsProjects (title, description, file_name, student_id) VALUES ('$title', '$description', '$file_name', '$userId')";

        if (mysqli_query($conn, $sql)) {
            $message = "New project added successfully!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add project - Project approvals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../components/studentsSidebar.php" ?>

            <div class="col-md-10">
                <div class="dashboard-header">
                    <h1 class="">Add New Project</h1>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="toast-container position-fixed top-0 end-0 p-3">
                        <div id="liveToast" class="toast align-items-center <?php echo strpos($message, 'Error') === false ? 'text-bg-success' : 'text-bg-danger'; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <?php echo $message; ?>
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <script>
                        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                        var toastList = toastElList.map(function(toastEl) {
                            return new bootstrap.Toast(toastEl);
                        });
                        toastList.forEach(toast => toast.show());
                    </script>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Project Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Project Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file_name" class="form-label">Upload File (optional)</label>
                        <input type="file" class="form-control" id="file_name" name="file_name">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Project</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
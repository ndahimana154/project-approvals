<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../php/connect.php";

if (!$_SESSION['user_id']) {
    header("Location:../index.php");
    exit();
}

$message = "";
$messageType = ""; // Variable to hold the type of message (success or error)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $projectId = mysqli_real_escape_string($conn, $_POST['project_id']);
    $studentId = mysqli_real_escape_string($conn, $_POST['student_id']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check if the student is already a member of the project
    $checkQuery = "SELECT * FROM project_members WHERE project_id = '$projectId' AND student_id = '$studentId'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $message = "Error: This student is already a member of the project.";
        $messageType = "error"; // Set message type to error
    } else {
        $sql = "INSERT INTO project_members (project_id, student_id, role) VALUES ('$projectId', '$studentId', '$role')";

        if (mysqli_query($conn, $sql)) {
            $message = "Project member added successfully!";
            $messageType = "success"; // Set message type to success
        } else {
            $message = "Error: " . mysqli_error($conn);
            $messageType = "error"; // Set message type to error
        }
    }
}

$students = [];
if (isset($_GET['project_id'])) {
    $projectId = mysqli_real_escape_string($conn, $_GET['project_id']);
    $query = "SELECT id, email FROM students"; // Adjust this query as needed
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project Member</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
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
                <?php if (!empty($message)): ?>
                    <div class="toast-container position-fixed top-0 end-0 p-3">
                        <div id="liveToast" class="toast <?php echo $messageType === "success" ? 'bg-success text-white' : 'bg-danger text-white'; ?>" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto"><?php echo $messageType === "success" ? 'Success' : 'Error'; ?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                <?php echo $message; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <input type="hidden" name="project_id" value="<?php echo $_GET['project_id']; ?>">
                    <div class="mb-3">
                        <label for="student_email" class="form-label">Student Email</label>
                        <input type="email" class="form-control" id="student_email" name="student_email" list="studentList" required>
                        <input type="hidden" id="student_id" name="student_id">
                        <datalist id="studentList">
                            <?php foreach ($students as $student): ?>
                                <option value="<?php echo htmlspecialchars($student['email']); ?>" data-id="<?php echo htmlspecialchars($student['id']); ?>">
                                <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" name="role" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Member</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const emailInput = document.getElementById('student_email');
        const studentIdInput = document.getElementById('student_id');
        const studentOptions = document.getElementById('studentList').options;

        emailInput.addEventListener('input', function() {
            // Find the selected option in the datalist
            for (let option of studentOptions) {
                if (option.value === emailInput.value) {
                    studentIdInput.value = option.dataset.id; // Set the student ID
                    return;
                }
            }
            studentIdInput.value = ''; // Clear the student ID if no match
        });

        // Show the toast if there's a message
        <?php if (!empty($message)): ?>
            const toastEl = document.getElementById('liveToast');
            const toast = new bootstrap.Toast(toastEl);
            toast.show(); // Show the toast
        <?php endif; ?>
    </script>
</body>

</html>
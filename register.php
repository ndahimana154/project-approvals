<?php
include './php/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
</head>

<body>
    <?php
    include("./components/outheader.php");
    ?>
    <div class="container" style="margin-top:100px">
        <h2 class="mt-5">Student Registration</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
            $regno = $_POST['regno'];
            $class = $_POST['class'];

            $checkEmail = "SELECT * FROM students WHERE email='$email'";
            $checkPhone = "SELECT * FROM students WHERE phone='$phone'";
            $checkRegno = "SELECT * FROM students WHERE phone='$regno'";

            $emailResult = $conn->query($checkEmail);
            $phoneResult = $conn->query($checkPhone);
            $regNoResult = $conn->query($checkRegno);

            if ($emailResult->num_rows > 0) {
                echo "<div class='alert alert-danger'>Error: Email already exists!</div>";
            } elseif ($phoneResult->num_rows > 0) {
                echo "<div class='alert alert-danger'>Error: Phone number already exists!</div>";
            } elseif ($regNoResult->num_rows > 0) {
                echo "<div class='alert alert-danger'>Error: Regno already exists!</div>";
            } else {
                $sql = "INSERT INTO students (firstname, lastname, email, phone, password, regno, class) 
                        VALUES ('$firstname', '$lastname', '$email', '$phone', '$password', '$regno', '$class')";

                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success'>Registration successful!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                }
            }
        } ?>
        <form method="POST" action="" class="mt-4  w-50">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="regno">Registration Number:</label>
                <input type="text" name="regno" class="form-control">
            </div>

            <div class="form-group">
                <label for="class">Class:</label>
                <input type="text" name="class" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->
</body>

</html>
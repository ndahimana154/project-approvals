<?php
include './php/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Project Approval System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgba(255, 193, 7, 0.1);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .full-height {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            flex: 1;
            display: flex;
            flex-direction: row;
            padding: 20px 0;
            position: absolute;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 100;
            width: 100%;
        }

        header .logo {
            flex: 1;
            padding: 10px;
            padding-top: 0;
        }

        header .logo a {
            text-decoration: none;
            color: #fff;
            font-size: 22px;
            font-weight: bold;
        }

        header .buttons {
            padding-right: 20px;
        }

        .carousel-container {
            flex: 2;
            display: flex;
            justify-content: center;
        }

        .carousel {
            width: 100%;
            height: 100%;
        }

        .carousel-inner img {
            object-fit: cover;
            height: 100%;
        }

        .carousel-caption {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .btn-outline-primary:hover,
        .btn-outline-danger:hover,
        .btn-outline-success:hover {
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #fff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            border-color: #28a745;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px;
            font-size: 0.9rem;
            margin-top: auto;
        }

        .card-deck {
            margin-top: 20px;
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <div class="full-height">
        <?php
        include("./components/outheader.php");
        ?>
        <div class="carousel-container">
            <div id="carouselExampleIndicators" class="carousel slide w-100" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./assets/images/1.jpg" class="d-block w-100" alt="Slide 1">
                        <div class="carousel-caption">
                            <h3>Streamlined Project Approvals</h3>
                            <p>Efficiently manage and approve student projects with ease.</p>
                            <a href="student-login.php" class="btn btn-primary btn-lg mx-2" style="min-width: 150px;">Student Login</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./assets/images/5.jpg" class="d-block w-100" alt="Slide 2">
                        <div class="carousel-caption">
                            <h3>Secure and Easy Access</h3>
                            <p>Admins and students can access the system with secure login options.</p>
                            <a href="admin-login.php" class="btn btn-danger btn-lg mx-2" style="min-width: 150px;">Admin Login</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./assets/images/6.jpg" class="d-block w-100" alt="Slide 3">
                        <div class="carousel-caption">
                            <h3>Register New Students</h3>
                            <p>Students can register and submit projects for quick approval.</p>
                            <a href="register.php" class="btn btn-success btn-lg mx-2" style="min-width: 150px;">Register</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

    </div>

    <div class="container card-deck">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://images.pexels.com/photos/7841853/pexels-photo-7841853.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top" alt="Card image 1">
                    <div class="card-body">
                        <h5 class="card-title">Admin portal</h5>
                        <p class="card-text">Access your dedicated student portal to submit projects for approval, track the review process, and communicate with your supervisors. Simplify project management and focus on what matters most—your work.</p>
                        <a href="admin-login.php" class="btn btn-danger btn-lg mx-2" style="min-width: 150px;">Admin Login</a>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://images.pexels.com/photos/267569/pexels-photo-267569.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top" alt="Card image 2">
                    <div class="card-body">
                        <h5 class="card-title">Student portal</h5>
                        <p class="card-text">Admins can review and approve student projects with ease. Manage the approval process, oversee project progress, and ensure timely completions all through a secure portal designed for administrators.</p>
                        <a href="student-login.php" class="btn btn-primary btn-lg mx-2" style="min-width: 150px;">Student Login</a>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://images.pexels.com/photos/28196491/pexels-photo-28196491/free-photo-of-construction-supervisor.jpeg?auto=compress&cs=tinysrgb&w=600" class="card-img-top" alt="Card image 3">
                    <div class="card-body">
                        <h5 class="card-title">Supervisor portal</h5>
                        <p class="card-text">"Supervisors can access the portal to monitor student progress, provide feedback, and approve project submissions. A streamlined system to facilitate communication and project oversight.</p>
                        <a href="admin-login.php" class="btn btn-success btn-lg mx-2" style="min-width: 150px;">Supervisor Login</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
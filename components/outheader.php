<header class="">
    <div class="logo">
        <a href="./index.php">
            Project <span>Approvals</span> System
        </a>
    </div>
    <div class="buttons">
        <a href="register.php" class="btn btn-outline-success">
            Student Signup
        </a>
    </div>
</header>

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
<header class="navbar">
    <div class="logo">
        <a href="./index.php">
        UTB Seamless Final Project Approval System
        </a>
    </div>
    <nav class="nav-links">
        <a href="https://www.utb.ac.rw/utb-history/" target="_blank">About Us</a>
        <a href="https://www.utb.ac.rw/" target="_blank">Online Platforms</a>
        <a href="https://www.utb.ac.rw/student/" target="_blank">Contact Us</a>
    </nav>
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

    header.navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 40px;
        background-color: rgba(0, 0, 0, 0.8);
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 100;
    }

    header .logo a {
        text-decoration: none;
        color: #fff;
        font-size: 24px;
        font-weight: bold;
        display: flex;
        align-items: center;
    }

    header .logo a:hover {
        color: #007bff;
    }

    header .nav-links {
        display: flex;
        gap: 20px;
    }

    header .nav-links a {
        text-decoration: none;
        color: #fff;
        font-size: 18px;
        padding: 10px;
        transition: color 0.3s ease;
    }

    header .nav-links a:hover {
        color: #007bff;
    }

    header .buttons {
        padding-right: 20px;
    }

    header .btn-outline-success {
        padding: 10px 20px;
        border: 2px solid #28a745;
        color: #28a745;
        background: none;
        transition: all 0.3s ease;
    }

    header .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
    }

    @media (max-width: 768px) {
        header .nav-links {
            display: none;
        }
    }
</style>
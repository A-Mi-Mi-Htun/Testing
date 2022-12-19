<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //$email = $_POST["email"];
    //$password = $_POST["password"];

    if (!empty($_SESSION["email"]) && !empty($_SESSION["password"])) {
        $user_valid = "Login successful";
    }
}
?>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="library/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery-3.3.1.min.js"></script>
<script src="library/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid bg-light">
    <div class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav pt-3 justify-content-between">
                    <li class="nav-item">
                        <p class="nav-link text-dark">Home</p>
                    </li>
                    <li class="nav-item <?php echo empty($user_valid)? "d-block": "d-none"; ?>">
                        <div class="">
                            <a href="login.php" class="btn btn-primary">Login</a>
                            <a href="register.php" class="btn btn-primary">Register</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php echo empty($user_valid)? "d-block": "d-none"; ?>">
                        <div class="dropdown btn-group">
                            <img class="img dropdown-toggle" data-bs-toggle="dropdown" src="img/user.png" alt="User">
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>                        
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="wrapper">
        <div class="row d-flex align-items-center text-center height">
            <div class="col-md-12">
                <h2>Welcome To My Website</h2>
            </div>
        </div>
    </div>
</div>

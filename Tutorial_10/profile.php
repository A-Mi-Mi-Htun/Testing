<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $email = "";
$name_err = $email_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please enter a email.";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $email_err = "Please enter a valid email.";
    } else {
        $email = $input_email;
    }

    if (isset($_POST["submit"])) {


    }


    // Close connection
    $conn->close();
}
?>

<link rel="stylesheet" href="css/reset.css">
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
<div class="container-fluid mt-3">
    <div class="wrapper w-50">
        <div class="row">
            <div class="col-md-12">
                <card class="card mt-3">
                    <div class="card-title p-2 bg-light rounded">
                        <h4 class="">My Profile Setting</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="mb-3">
                                <input type="file" id="upload-image" class="hidden">
                                <div class="me-5 d-inline">
                                    <?php
                                    require "config.php";
                                    $sql = "SELECT img FROM user";
                                    if ($result = $conn->query($sql)) {
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $img = $row["img"];
                                            }                              
                                        }
                                    }
                                    ?>
                                    <img id="profile" class="profile-img" src="img/<?php echo $img ?>" alt="">
                                </div>
                                <input type="file" name="img" accept="image/*" class="file" id="actual-btn" hidden/>
                                <label onchange="updatePreview(this, 'profile');" class="upload-btn" id="file" for="actual-btn">Upload</label>
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2">Name</label>
                                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" placeholder="name">
                                <span class="invalid-feedback"><?php echo $name_err; ?></span>
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2">Email</label>
                                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="name@example.com">
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group mb-3 d-flex justify-content-end">
                                <input type="submit" class="btn btn-primary" value="Update">
                            </div>
                        </form>
                    </div>
                </card>
            </div>
            <div class="col-md-12 mt-3 <?php echo empty($error)? "d-none": "d-block"; ?>">
                <div class="alert alert-danger"><?php echo $error ?></div>
            </div>
        </div>
    </div>
</div>
<script>
function updatePreview(input, target) {
    
    $file = input.files[0];
    $reader = new FileReader();

    reader.readAsDataURL(file);
    reader.onload = function () {
        $img = document.getElementById(target);
        img.src = reader.result;
    }
}
//    function changeBtn(input) {
//        //var file = $("input[type=file]").get(0).files[0];
//
//        if (input.files && input.files[0]) {
//            var reader = new FileReader();
//            reader.onload = function(e) {
//                $("#profile").attr("src", e.target.result);
//            }
//
//            reader.readAsDataURL(input.files[0]);  
//        }
//    }
//
//    $("#profile").change(function() {
//        readURL(this);
//    });

//const previewImage = (event) => {
//    const imageFiles = event.target.files;
//    const imageFilesLength = imagesFiles.length;
//
//    if (imagesFilesLength > 0) {
//        const imageSrc = URL.createObjectURL(imagesFiles[0]);
//        const imagePreviewElement = document.querySelector("#profile");
//        imagePreviewElement.src = imageSrc;
//        imagePreviewElement.style.display = "block";
//    }
//};
</script>
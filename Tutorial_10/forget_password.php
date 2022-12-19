<?php
// Include config file
require_once "config.php";

    function sendmail($email,$reset_token){
        
        require ('library/vendor/phpmailer/phpmailer/src/PHPMailer.php');
        require ('library/vendor/phpmailer/phpmailer/src/Exception.php');
        require ('library/vendor/phpmailer/phpmailer/src/SMTP.php');

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;            
            $mail->Username   = 'your email';
            $mail->Password   = 'your password';                    
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   
            $mail->Port       = 465;                           

            $mail->setFrom('your email');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset link form Aatmaninfo';
            $mail->Body    = "we got a request form you to reset Password! <br>Click the link bellow: <br>
            <a href='http://localhost:8000/updatePassword.php?email=$email&reset_token=$reset_token'>reset password</a>";

            $mail->send();
                return true;
        } catch (Exception $e) {
                return false;
        }
    }

// Define variables and initialize with empty values
$email = "";
$email_err = "";

// Processing form data when form is submitted
//$sql = "SELECT * FROM user where email = '$email'";
//if ($result = $conn->query($sql)) {
//    if ($result->num_rows > 0) {
//        while ($row = $result->fetch_assoc()) {
//            $email = $row["email"];
//        }
//
//    }
//}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //$email = $_POST["email"];

    $sql = "SELECT * FROM user where id = ?";

    if ($result = $conn->query($sql)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $email = $row["email"];
                }
        
            }
        }

    $result = $conn->query($sql);

        if ($result) {
            
            if ($row = $result->fetch_assoc()) {
                
                $reset_token=bin2hex(random_bytes(16));
                date_default_timezone_set('Asia/yangon');
                $date = date("Y-m-d");

                $sql = "UPDATE user SET resettoken ='$reset_token', resettokenexp = '$date' WHERE email = '$email'";

                if (($conn->query($sql)===TRUE) && sendmail($email,$reset_token )===TRUE) {
                        echo "
                            <script>
                                alert('Password reset link send to mail.');
                                window.location.href='index.php'    
                            </script>"; 
                    }else{
                        echo "
                            <script>
                                alert('Something got Wrong');
                                window.location.href='forget_password.php'
                            </script>";
                    }

            }else{
                echo "
                    <script>
                        alert('Email Address Not Found');
                        window.location.href='forgotPassword.php'
                    </script>";
            }   
            
        }else{
            echo "
                <script>
                    alert('Server Down');
                    window.location.href='forgotPassword.php'
                </script>";
        }
    
}

// Close connection
$conn->close();
?>

<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="library/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

<div class="container-fluid">
    <div class="wrapper w-50">
        <div class="row">
            <div class="col-md-12">
                <card class="card mt-3">
                    <div class="card-title p-2 bg-light rounded">
                        <h4 class="">Forget Password</h4>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="card-body">

                            <div class="form-group mb-3">
                                <label class="mb-2">Email</label>
                                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="name@example.com">
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>
                        </div>

                        <div class="pe-3 ps-3 pt-3 bg-light d-flex justify-content-between">
                            <div class="form-group mb-3">
                                <a href="login.php" class="text-decoration-none">Login</a>
                            </div>
                            <div class="form-group mb-3">
                                <input type="submit" class="btn btn-primary" value="Send">
                            </div>
                        </div>
                    </form>
                </card>
            </div>
        </div>
    </div>
</div>
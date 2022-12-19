<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $email = $phone = $password = $address = "";
$name_err = $email_err = $phone_err = $password_err = $address_err = "";

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

    $input_phone = trim($_POST["phone"]);
    if (empty($input_phone)) {
        $phone_err = "Please enter a phone number.";
    } elseif (!preg_match('/^[0-9]{11}+$/', $input_phone)) {
        $phone_err = "Please enter a valid phone number";
    } else {
        $phone = $input_phone;
    }

    $input_password = ($_POST["password"]);
    if (empty($input_password)) {
        $password_err = "Please enter a password.";
    } elseif (strlen($input_password) < 8) {
        $password_err = "Password should be at least 8 characters.";
    } else {
        $password = $input_password;
    }

    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter a address.";
    } else {
        $address = $input_address;
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($password_err) && empty($address_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO user (name, email, phone, password, address) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss", $param_name, $param_email, $param_phone, $param_password, $param_address);

            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_phone = $phone;
            $param_password = $password;
            $param_address = $address;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
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
                        <h4 class="">Register</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                            <div class="form-group mb-3">
                                <label class="mb-2">Phone</label>
                                <input type="number" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>" placeholder="09*********">
                                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2">Password</label>
                                <input type="password" name="password" min="8" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2">Address</label>
                                <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                                <span class="invalid-feedback"><?php echo $address_err; ?></span>
                            </div>
                            <div class="form-group mb-3 d-grid gap-2">
                                <input type="submit" class="btn btn-primary" value="Register">
                            </div>
                            <div class="form-group text-center">
                                <a href="login.php" class="text-decoration-none">Already have an account?</a>
                            </div>
                        </form>
                    </div>
                </card>
            </div>
        </div>
    </div>
</div>
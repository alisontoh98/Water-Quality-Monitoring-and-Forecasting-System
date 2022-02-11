<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $fullname = $email = $contactnumber = $status = "";
$username_err = $password_err = $confirm_password_err = $fullname_err = $email_err = $contactnumber_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT STAFF_ID FROM fish_hatchery_staff WHERE STAFF_USERNAME = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
	
	// Validate fullname
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter a full name.";     
    } else{
        $fullname = trim($_POST["fullname"]);
    }

	//Validate email
	if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
	}elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Invalid email format.";
	}else{
        $email = trim($_POST["email"]);
    }
	
	// Validate contactnumber
    if(empty(trim($_POST["contactnumber"]))){
        $contactnumber_err = "Please enter a contactnumber.";     
    } elseif(!filter_var(trim($_POST["contactnumber"]), FILTER_SANITIZE_NUMBER_INT)){
        $contactnumber_err = "Invalid contact number format.";
	}else{
        $contactnumber = trim($_POST["contactnumber"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)&& empty($fullname_err)&& empty($email_err)&& empty($contactnumber_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO fish_hatchery_staff (STAFF_USERNAME, STAFF_PASSWORD, STAFF_FULL_NAME, STAFF_EMAIL, STAFF_PHONE_NUM, STAFF_STATUS) VALUES (?, ?, ?, ?, ?, 'Pending')";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_password, $param_fullname, $param_email, $param_contactnumber);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_BCRYPT); // Creates a password hash
            $param_fullname = $fullname;
			$param_email = $email;
			$param_contactnumber = $contactnumber;
        
			
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
				echo "<script type='text/javascript'>alert('Your account is now pending for approval.'); window.location.href = 'login.php';</script>";
                //header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="CSS/login.css">
    <title>Register</title>
</head>
<body>
<form action="register.php" method="post">  
<div class="header">
<center><h1>Water Quality Monitoring and Forecasting System</h1></center>
</div>
	<div class="register">
        <h1>Registration Form</h1>
        <p style="color:#555">Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <p>
			<div class="form-group">
                <label style="color:#555">Username<span style="color:#ff0000">*</span></label>
                <input type="text" name="username" required="" class="form-contro <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" required>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>   
			</p>
			<p>			
            <div class="form-group">
                <label style="color:#555">Password<span style="color:#ff0000">*</span></label>
                <input type="password" minlength="6" name="password" required=""  class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" required>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
			</p>
			<p>
            <div class="form-group">
                <label style="color:#555">Confirm Password<span style="color:#ff0000">*</span></label>
                <input type="password" name="confirm_password" required="" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" required>
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
			</p>
			<p>
			<div class="form-group">
                <label style="color:#555">Full Name<span style="color:#ff0000">*</span></label>
                <input type="text" name="fullname" required="" class="form-control <?php echo (!empty($fullname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fullname; ?>" required>
                <span class="invalid-feedback"><?php echo $fullname_err; ?></span>
            </div>
			</p>
			<p>
			<div class="form-group">
                <label style="color:#555">Email<span style="color:#ff0000">*</span></label>
                <input type="email" name="email" required="" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" required>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
			</p>
			<p>
			<div class="form-group">
                <label style="color:#555">Contact Number<span style="color:#ff0000">*</span></label>
                <input type="text" name="contactnumber" required="" class="form-control <?php echo (!empty($contactnumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contactnumber; ?>" required>
                <span class="invalid-feedback"><?php echo $contactnumber_err; ?></span>
            </div>
			</p>
			<p>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <button type="reset" class="btn btn-seconday ml-2" value="Reset">Reset</button>
            </div>
			</p>
            <p style="font-size:14px; text-align:center; color:#555">Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>
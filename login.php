<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: homepage.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT STAFF_ID, STAFF_USERNAME, STAFF_PASSWORD FROM fish_hatchery_staff WHERE STAFF_USERNAME = ? && STAFF_STATUS = 'Approved'";
    

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
            
                             session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["STAFF_ID"] = $id;
                            $_SESSION["STAFF_USERNAME"] = $username;                            
                            
                            
                            // Redirect user to welcome page
                            header("location: homepage.php");
                            
                        }else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                }else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            }else{
                
                $login_err = "Oops! Something went wrong. Please try again later.";
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="CSS/login.css">
	<title>Login</title>

</head>
<body>
<form action="login.php" method="post">
<div class="header">
<center><h1>Water Quality Monitoring and Forecasting System</h1></center>
</div>
    <div class="login">
		<h1>User Login</h1>

		<i class="fa fa-user-circle" style="font-size:100px; color:#555; text-align:center; width:100% "></i>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <p>
			<div class="form-group">
                <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
			</p>   
			<p>
            <div class="form-group">
				<input type="password" name="password" id="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
				<span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
			</p>
			<p>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
			</p>
			<?php 
			if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
			}        
			?>
            <p style="font-size:14px; color:#555; text-align:center"> Click here to <a href="register.php">Register</a>.</p>
            <p style="font-size:14px; color:#555; text-align:center"> Login as <a href="admin_login.php">Admin</a>.</p>
        </form>
    </div>
</body>
</html>
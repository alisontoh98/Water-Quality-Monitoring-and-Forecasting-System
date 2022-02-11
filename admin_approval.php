<?php
    include "config.php";
?>

<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php
//login&logout section
if(isset($_SESSION["ADMIN_ID"])){
echo '<p style="text-align:right"> Welcome '. $_SESSION["ADMIN_USERNAME"] . '! <a href="logout.php">Logout</a></p>';
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="CSS/admin_account.css">
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<title>Admin Approval</title>

<script> 
function display_c(){
	var refresh=1000; // Refresh rate in milli seconds
	mytime=setTimeout('display_ct()',refresh)
}

function display_ct() {
	var x = new Date()
	var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
	hours = x.getHours( ) % 12;
	hours = hours ? hours : 12;
	hours=hours.toString().length==1? 0+hours.toString() : hours;

	var minutes=x.getMinutes().toString()
	minutes=minutes.length==1 ? 0+minutes : minutes;

	var seconds=x.getSeconds().toString()
	seconds=seconds.length==1 ? 0+seconds : seconds;

	var month=(x.getMonth() +1).toString();
	month=month.length==1 ? 0+month : month;

	var dt=x.getDate().toString();
	dt=dt.length==1 ? 0+dt : dt;

	var x1= dt + "/" + month + "/" + x.getFullYear(); 
	x1 = x1 + " - " +  hours + ":" +  minutes + ":" +  seconds + " " + ampm;
	document.getElementById('ct').innerHTML = x1;
	display_c();
 }
</script>
</head>

<body onload=display_ct();>
	<div class="header">
		<h1>Water Quality Monitoring and Forecasting System</h1>
	</div>
    <p>
        &nbsp&nbsp<a style="color:#ffffff" href = "admin_approval.php">Account Approval List</a> &nbsp&nbsp
        <a style="color:#ffffff" href = "admin_account.php">User Account List</a>&nbsp&nbsp
        

    </p>
	<div class="title">
		<h2 class="aligncenter" style="font-size: 30px">Account Approval List</h2>
	</div>
<p style="text-align:right" id='ct'></p>
<br><br>
<div id="container" >
	<?php
        $res = mysqli_query($link, "SELECT * FROM fish_hatchery_staff WHERE STAFF_STATUS='Pending' ");
        if(mysqli_num_rows($res)==0){
            echo "No new registration found.";
        }
        else{
    ?>
        <table>
            <thead>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Action</th>
                
            </thead>
            <?php
        }?>
        <?php

            while($row=mysqli_fetch_assoc($res)){
               
                ?>
                <tr>
                <td> <?php echo $row['STAFF_USERNAME']; ?> </td>
                <td> <?php echo $row['STAFF_FULL_NAME']; ?> </td>
                <td> <?php echo $row['STAFF_EMAIL']; ?> </td>
                <td> <?php echo $row['STAFF_PHONE_NUM']; ?> </td>

                <td>
                <form action="admin_approval.php"  method="post">
                <input type = "hidden" name="id" value ="<?php echo $row['STAFF_ID'];?>"/>
                <button type="submit" name="approve" onclick="return confirm('Confirm this user?')" class="button1"><span style="color:white" class="fa fa-check"></span>&nbsp Approve</button>
                <button type="submit" name="deny" onclick="return confirm('Reject this user?')" class="button2"><span style="color:white" class="fa fa-close"></span>&nbsp Remove</button>
                </form>
                </td>
                </tr>
                <?php
            }
            ?>
        </table>

        
        <?php
        if(isset($_POST['approve'])){
            $id = $_POST['id'];

            mysqli_query($link,"UPDATE fish_hatchery_staff SET STAFF_STATUS='Approved' WHERE STAFF_ID ='$id'");
            echo "<script type='text/javascript'>alert('User Approved!'); window.location.href = 'admin_approval.php';</script>";
            
            
        }
        if(isset($_POST['deny'])){
            $id = $_POST['id'];
            
            mysqli_query($link,"DELETE FROM fish_hatchery_staff WHERE STAFF_ID ='$id' AND STAFF_STATUS='Pending'");
            echo "<script type='text/javascript'>alert('User Removed!'); window.location.href = 'admin_approval.php';</script>";
            
        }
        ?>

    

</div> 
</body>
</html>
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
if(isset($_SESSION["STAFF_ID"])){
echo '<p style="text-align:right"> Welcome '. $_SESSION["STAFF_USERNAME"] . '! <a href="logout.php">Logout</a></p>';
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="CSS/real_time.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<title>Real time Water Quality</title>

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

function selectFishTank(){
    var z = document.getElementById("waterquality").value;
    $.ajax({
        url:"showTemperatureData.php",
        method:"POST",
        data:{
            id : z
        },
    success:function(data){
        $("#wt").html(data);
    }
    })
    $.ajax({
        url:"showPHData.php",
        method:"POST",
        data:{
            id : z
        },
    success:function(data){
        $("#ph").html(data);
    }
    })
    $.ajax({
        url:"showDOData.php",
        method:"POST",
        data:{
            id : z
        },
    success:function(data){
        $("#do").html(data);
    }
    })
}

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script defer src="js/script.js"></script>
</head>

<body onload=display_ct();>
	<div class="header">
		<h1>Water Quality Monitoring and Forecasting System</h1>
	</div>
    <p>
        &nbsp&nbsp<a style="color:#ffffff" href = "real_time.php ">Real-time Water Quality</a> &nbsp&nbsp
        <a style="color:#ffffff" href = "historical.php ">Historical Water Quality</a>&nbsp&nbsp
        <a style="color:#ffffff" href = "forecast.php ">Forecast Water Quality</a>

    </p>
	<div class="title">
		<h2 class="aligncenter" style="font-size: 30px">Real-time Water Quality</h2>
		<button data-modal-target="#modal" type="button" class="icon-button">
    	<span class="material-icons">notifications</span>
    	<?php 
					$con = mysqli_connect("localhost", "root", "","water quality");
					$sql = "SELECT WATER_TEMPERATURE, PH_VALUE, DISSOLVED_OXYGEN FROM water_quality_data WHERE FISH_TANK_NUMBER = 1 ORDER BY DATA_ID DESC LIMIT 1";
					$res = mysqli_query($con, $sql);
					
					while($rows = mysqli_fetch_array($res)){
				?>
				<?php
					
					$TEMP = $rows['WATER_TEMPERATURE'];
					$PH = $rows['PH_VALUE'];
					$DO = $rows['DISSOLVED_OXYGEN'];

					if($DO < 5.00 ){
						echo "<span class='icon-button__badge'></span>";
						
					}
					else if($PH < 7.00 || $PH > 8.50){
						echo "<span class='icon-button__badge'></span>";
						
					}
					else if($TEMP < 15.60 || $TEMP > 29.40 ){
						echo "<span class='icon-button__badge'></span>";
						
					}
					else{
						echo " ";
					} 
					?>
				<?php
        			} 
    			?>
				<?php 
					$con = mysqli_connect("localhost", "root", "","water quality");
					$sql2 = "SELECT WATER_TEMPERATURE, PH_VALUE, DISSOLVED_OXYGEN FROM water_quality_data WHERE FISH_TANK_NUMBER = 2 ORDER BY DATA_ID DESC LIMIT 1";
					$res2 = mysqli_query($con, $sql2);
					
					while($rows = mysqli_fetch_array($res2)){
				?>
				<?php
					
					$TEMP = $rows['WATER_TEMPERATURE'];
					$PH = $rows['PH_VALUE'];
					$DO = $rows['DISSOLVED_OXYGEN'];

					if($DO < 5.00 ){
						echo "<span class='icon-button__badge'></span>";
						
					}
					else if($PH < 7.00 || $PH > 8.50){
						echo "<span class='icon-button__badge'></span>";
						
					}
					else if($TEMP < 15.60 || $TEMP > 29.40 ){
						echo "<span class='icon-button__badge'></span>";
						
					}
					else{
						echo " ";
					} 
					?>
				<?php
        			} 
    			?>
				<?php 
					$con = mysqli_connect("localhost", "root", "","water quality");
					$sql3 = "SELECT WATER_TEMPERATURE, PH_VALUE, DISSOLVED_OXYGEN FROM water_quality_data WHERE FISH_TANK_NUMBER = 3 ORDER BY DATA_ID DESC LIMIT 1";
					$res3 = mysqli_query($con, $sql3);
					
					while($rows = mysqli_fetch_array($res3)){
				?>
				<?php
					
					$TEMP = $rows['WATER_TEMPERATURE'];
					$PH = $rows['PH_VALUE'];
					$DO = $rows['DISSOLVED_OXYGEN'];

					if($DO < 5.00 ){
						echo "<span class='icon-button__badge'></span>";
						
					}
					else if($PH < 7.00 || $PH > 8.50){
						echo "<span class='icon-button__badge'></span>";
						
					}
					else if($TEMP < 15.60 || $TEMP > 29.40 ){
						echo "<span class='icon-button__badge'></span>";
						
					}
					else{
						echo " ";
					} 
					?>
				<?php
        			} 
    			?>
  		</button>
          <div class="modal" id="modal">
			<div class="modal-header">
				<div class="title">Notification</div>
				<button data-close-button class="close-button">&times;</button>
				</div>
			<div class="modal-body">
            <?php 
					$con = mysqli_connect("localhost", "root", "","water quality");
					$sql = "SELECT WATER_TEMPERATURE, PH_VALUE, DISSOLVED_OXYGEN FROM water_quality_data WHERE FISH_TANK_NUMBER = 1 ORDER BY DATA_ID DESC LIMIT 1";
					$res = mysqli_query($con, $sql);
					
					while($rows = mysqli_fetch_array($res)){
				?>
				<?php
					$TEMP = $rows['WATER_TEMPERATURE'];
					$PH = $rows['PH_VALUE'];
					$DO = $rows['DISSOLVED_OXYGEN'];

					if($DO < 5.00 ){
						echo "Fish tank 1 is in poor condition!";
						echo "<br> <br>";
						echo "<a href='real_time.php'>View Details</a> ";
						echo "<br> <br>";
						
					}
					else if($PH < 7.00 || $PH > 8.50){
						echo "Fish tank 1 is in poor condition!";
						echo "<br> <br>";
						echo "<a href='real_time.php'>View Details</a> ";
						echo "<br> <br>";
						
					}
					else if($TEMP < 15.60 || $TEMP > 29.40 ){
						echo "Fish tank 1 is in poor condition!";
						echo "<br> <br>";
						echo "<a href='real_time.php'>View Details</a> ";
						echo "<br> <br>";
						
					}
					else{
						echo "Fish tank 1 is in good condition.";
						echo "<br> <br>";
					} 
					?>
				<?php
        			} 
    			?>
				<?php 
					$con = mysqli_connect("localhost", "root", "","water quality");
					$sql2 = "SELECT WATER_TEMPERATURE, PH_VALUE, DISSOLVED_OXYGEN FROM water_quality_data WHERE FISH_TANK_NUMBER = 2 ORDER BY DATA_ID DESC LIMIT 1";
					$res2 = mysqli_query($con, $sql2);
					
					while($rows = mysqli_fetch_array($res2)){
				?>
				<?php
					
					$TEMP = $rows['WATER_TEMPERATURE'];
					$PH = $rows['PH_VALUE'];
					$DO = $rows['DISSOLVED_OXYGEN'];

					if($DO < 5.00 ){
						echo "Fish tank 2 is in poor condition!";
						echo "<br> <br>";
						echo "<a href='real_time.php'>View Details</a> ";
						echo "<br> <br>";
						
						
					}
					else if($PH < 7.00 || $PH > 8.50){
						echo "Fish tank 2 is in poor condition!";
						echo "<br> <br>";
						echo "<a href='real_time.php'>View Details</a> ";
						echo "<br> <br>";
						
						
					}
					else if($TEMP < 15.60 || $TEMP > 29.40 ){
						echo "Fish tank 2 is in poor condition!";
						echo "<br> <br>";
						echo "<a href='real_time.php'>View Details</a> ";
						echo "<br> <br>";
				
						
					}
					else{
						echo "Fish tank 2 is in good condition.";
						echo "<br> <br>";
					} 
					?>
				<?php
        			} 
    			?>
				<?php 
					$con = mysqli_connect("localhost", "root", "","water quality");
					$sql3 = "SELECT WATER_TEMPERATURE, PH_VALUE, DISSOLVED_OXYGEN FROM water_quality_data WHERE FISH_TANK_NUMBER = 3 ORDER BY DATA_ID DESC LIMIT 1";
					$res3 = mysqli_query($con, $sql3);
					
					while($rows = mysqli_fetch_array($res3)){
				?>
				<?php
					
					$TEMP = $rows['WATER_TEMPERATURE'];
					$PH = $rows['PH_VALUE'];
					$DO = $rows['DISSOLVED_OXYGEN'];

					if($DO < 5.00 ){
						echo "Fish tank 3 is in poor condition!";
						echo "<br> <br>";
						echo "<a href='real_time.php'>View Details</a> ";
						echo "<br> <br>";
						
					}
					else if($PH < 7.00 || $PH > 8.50){
						echo "Fish tank 3 is in poor condition!";
						echo "<br> <br>";
						echo "<a href='real_time.php'>View Details</a> ";
						echo "<br> <br>";
						
					}
					else if($TEMP < 15.60 || $TEMP > 29.40 ){
						echo "Fish tank 3 is in poor condition!";
						echo "<br> <br>";
						echo "<a href='real_time.php'>View Details</a> ";
						echo "<br> <br>";
						
					}
					else{
						echo "Fish tank 3 is in good condition.";
						echo "<br> <br>";
					} 
					?>
				<?php
        			} 
    			?>
			</div>
		</div>
        <div id="overlay"></div>
	</div>
    
<p style="text-align:right" id='ct'></p>

<div id="container">
    Fish Tank:
    <select id="waterquality" onchange="selectFishTank()">
        <?php
        $con = mysqli_connect("localhost", "root", "","water quality");
        $sql = "SELECT DISTINCT FISH_TANK_NUMBER FROM water_quality_data";
        $res = mysqli_query($con, $sql);
        ?>
    <option disabled selected>-- Select Fish Tank --</option>
        <?php while( $rows = mysqli_fetch_array($res)){
            ?>
            <option value="<?php echo $rows['FISH_TANK_NUMBER']; ?>"> <?php echo $rows['FISH_TANK_NUMBER']; ?> </option>
        <?php
        }
        ?>
    </select>
    <div class="row">
        <div class="column">
            <p>Temperature</p>
        </div>
        <div class="column">
            <p>pH Value</p>
        </div>
        <div class="column">
            <p>Dissolved Oxygen</p>
        </div>
        <div class="box" id="wt">
        </div>
        <div class="box" id="ph">
        </div>
        <div class="box" id="do">
        </div>
    </div>
	<p> Notes: Green color indicates good condition; Red color indicates poor condition.</p>
	<p> Optimal Reading for Water Parameters:</p>
	<p>	Water Temepature: Between 15.60°C and 29.40°C </p>
	<p>	pH Value: Between 7 and 8.5</p>
	<p>	Dissolved Oxygen: More than 5ppm</p>
	 
</div> 
</body>
</html>
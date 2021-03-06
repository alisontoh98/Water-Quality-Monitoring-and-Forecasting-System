<?php
// Include config file
require_once "config.php";

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
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="CSS/forecast.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="CSS/jquery-ui.css">
	<title>Forecast Water Quality</title>

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

function goPython(){
	var z = document.getElementById("forecast").value;
	
    $.ajax({
        url:"showForecastData.php",
        method:"POST",
        data:{
            id : z
        },
		success:function(data){
            $("#ans").html(data);
        }
    })
}

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script defer src="js/script.js"></script>
<title>Forecast Water Quality</title>
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
		<h2 class="aligncenter" style="font-size: 30px">Forecast Water Quality</h2>
		<button data-modal-target="#modal"  type="button" class="icon-button">
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
  <select id="forecast" onchange="goPython()">
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
  <p>Notes: Forecast will take 30 seconds to run after choosing Fish Tank Number.</p>
  <p>Notes: Water temperature, pH value and dissolved oxygen will be forecasted for 7 days future.</p>
<p></p>
<div class="row">
    <table class="center">
			<th>Fish Tank No.</th>
            <th>Date</th>
            <th>Water Temperature (??C)</th>
            <th>pH Value</th>
            <th>Dissolved Oxygen (mg/L)</th>
        <tbody id="ans"></tbody>
    </table>
    </div> 
    
</div> 
</body>
</html>
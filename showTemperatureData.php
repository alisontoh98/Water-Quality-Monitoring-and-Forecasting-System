<?php
      $k = $_POST['id'];
      $k = trim($k);
      $con = mysqli_connect("localhost", "root", "","water quality");
      $sql = "SELECT * FROM water_quality_data WHERE FISH_TANK_NUMBER='{$k}' ORDER BY DATA_ID DESC LIMIT 1 ";
      $res = mysqli_query($con, $sql);
      
      while($rows = mysqli_fetch_array($res)){
    ?>
        <?php 
        $Temp = $rows['WATER_TEMPERATURE'];
    
        if($Temp > 15.60 && $Temp < 29.40){
            echo "<font color=\"#2FC633\">";
            echo $Temp; echo '°C';
            
        }
        else if($Temp < 15.60 || $Temp > 29.40){
            echo "<font color=\"FF0000\">";
            echo $Temp; echo '°C';
        }
        ?>
        
       
    <?php
        } 
    ?>
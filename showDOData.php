<?php
      $k = $_POST['id'];
      $k = trim($k);
      $con = mysqli_connect("localhost", "root", "","water quality");
      $sql = "SELECT * FROM water_quality_data WHERE FISH_TANK_NUMBER='{$k}' ORDER BY DATA_ID DESC LIMIT 1";
      $res = mysqli_query($con, $sql);
      
      while($rows = mysqli_fetch_array($res)){
    ?>
        <?php 
        $DO = $rows['DISSOLVED_OXYGEN'];
    
        if($DO > 5.00){
            echo "<font color=\"#2FC633\">";
            echo $DO; echo 'mg/L';
            
        }
        else if($DO < 5.00){
            echo "<font color=\"FF0000\">";
            echo $DO; echo 'mg/L';
        } ?>
        
       
    <?php
        } 
    ?>
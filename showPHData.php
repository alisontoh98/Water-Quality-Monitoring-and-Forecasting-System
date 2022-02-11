<?php
      $k = $_POST['id'];
      $k = trim($k);
      $con = mysqli_connect("localhost", "root", "","water quality");
      $sql = "SELECT * FROM water_quality_data WHERE FISH_TANK_NUMBER='{$k}' ORDER BY DATA_ID DESC LIMIT 1";
      $res = mysqli_query($con, $sql);
      
      while($rows = mysqli_fetch_array($res)){
    ?>
        <?php 
 
            $PH = $rows['PH_VALUE'];
    
            if($PH > 7.00 && $PH < 8.50){
                echo "<font color=\"#2FC633\">";
                echo $PH;
                
            }
            else if($PH < 7.00 || $PH > 8.50){
                echo "<font color=\"FF0000\">";
                echo $PH;
            }
        ?>
        
        
       
    <?php
        } 
    ?>
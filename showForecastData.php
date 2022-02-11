<?php
      $k = $_POST['id'];
      $k = trim($k);
      if($k == 1){
        $output = exec("C:\Users\asus\AppData\Local\Programs\Python\Python39\python.exe forecast_1.py");
      }
      elseif($k == 2){
        $output = exec("C:\Users\asus\AppData\Local\Programs\Python\Python39\python.exe forecast_2.py");
      }
      elseif($k == 3){
        $output = exec("C:\Users\asus\AppData\Local\Programs\Python\Python39\python.exe forecast_3.py");
      }
      
      $con = mysqli_connect("localhost", "root", "","water quality");
      $sql = "(SELECT * FROM forecast_water_quality_data WHERE FISH_TANK_NUMBER='{$k}' ORDER BY FORCA_ID DESC LIMIT 7) ORDER BY FORCA_ID ASC;";
      $res = mysqli_query($con, $sql);
      
      while($rows = mysqli_fetch_array($res)){
?>
        <tr>
            <td> <?php echo $rows['FISH_TANK_NUMBER']; ?></td>
            <td> <?php echo $rows['FORCA_DATE']; ?></td>
            <td> <?php echo $rows['FORCA_WATER_TEMPERATURE']; ?></td>
            <td> <?php echo $rows['FORCA_PH_VALUE']; ?></td>
            <td> <?php echo $rows['FORCA_DISSOLVED_OXYGEN']; ?></td>
        </tr>
    <?php
        } 
        //echo $sql;
    ?>

<?php
      $k = $_POST['id'];
      $k = trim($k);
      $con = mysqli_connect("localhost", "root", "","water quality");
      $sql = "SELECT * FROM water_quality_data WHERE FISH_TANK_NUMBER='{$k}'";
      $res = mysqli_query($con, $sql);
      
      while($rows = mysqli_fetch_array($res)){
?>
        <tr>
            <td> <?php echo $rows['DATE_TIME']; ?></td>
            <td> <?php echo $rows['WATER_TEMPERATURE']; ?></td>
            <td> <?php echo $rows['PH_VALUE']; ?></td>
            <td> <?php echo $rows['DISSOLVED_OXYGEN']; ?></td>
        </tr>
    <?php
        } 
        echo $sql;
    ?>

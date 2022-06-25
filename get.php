<?php
    include 'connect.php';

    $query = "SELECT * FROM `alarm` WHERE `alarm`.`id` = 1";
    $select = mysqli_query($connection, $query);

    if (!$select) {
      DIE("QUERY FAILED". mysqli_error($connection));
    }
    $row = mysqli_fetch_array($select);

    echo $row['state'];
?>
<?php
    include 'connect.php';

    $query = "UPDATE `alarm` SET `state` = '0' WHERE `alarm`.`id` = 1";
    $connection->query($query);
?>
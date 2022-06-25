<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpswd = '';
$dbname = 'ships';

$connection = mysqli_connect($dbhost, $dbuser, $dbpswd, $dbname);

if(!$connection) {
    die("Database connection failed");
}

?>
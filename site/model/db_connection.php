<?php

$servername = "localhost";
$username = "root";
$password = "root";

try {
    $connection = new PDO("mysql:host=$servername;dbname=countriesAndIntlAffairs;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $connection->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
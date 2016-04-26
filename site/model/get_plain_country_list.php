<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get Countries and Regions table data */
$query = $connection->prepare("
    SELECT *
    FROM Countries
    ORDER BY name ASC
");
$query->execute();
$countries = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($countries);
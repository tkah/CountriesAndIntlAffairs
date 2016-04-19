<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get all treaties */
$query = $connection->prepare("
    SELECT *
    FROM Treaties
    ORDER BY name
");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($res);
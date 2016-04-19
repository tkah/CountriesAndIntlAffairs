<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get Countries and Regions table data */
$query = $connection->prepare("
    SELECT *
    FROM Conflicts
    ORDER BY start ASC
");
$query->execute();
$conflicts = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($conflicts);
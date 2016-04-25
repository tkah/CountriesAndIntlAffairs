<?php

if (!isset($connection)) require_once("db_connection.php");
/* Get POSTed in language */
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$origCountry = $request->origCountry;
$destCountry = $request->destCountry;

/* Get all migration data */
$query = $connection->prepare("
    SELECT totalAmount, inYear
    FROM Migrations
    WHERE destCountry = (SELECT countryNumber FROM Countries WHERE name = :destCountry)
    AND origCountry = (SELECT countryNumber FROM Countries WHERE name = :origCountry)
");
$query->bindValue(':destCountry', $destCountry, PDO::PARAM_STR);
$query->bindValue(':origCountry', $origCountry, PDO::PARAM_STR);
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($res);
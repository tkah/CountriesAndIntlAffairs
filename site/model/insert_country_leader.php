<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get POSTed in conflict id */
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$leader = $request->leader;
$country = $request->country;

$query = $connection->prepare("
    INSERT INTO Leaders
    VALUES (:name, :type, :termStart, :termEnd)
");
$query->bindValue(':name', $leader->name, PDO::PARAM_STR);
$query->bindValue(':type', $leader->type, PDO::PARAM_STR);
$query->bindValue(':termStart', $leader->termStart, PDO::PARAM_STR);
$query->bindValue(':termEnd', $leader->termEnd, PDO::PARAM_STR);
$query->execute();

$query = $connection->prepare("
    INSERT INTO LeaderOf
    VALUES (:c_code, :name)
");
$query->bindValue(':c_code', $country, PDO::PARAM_STR);
$query->bindValue(':name', $leader->name, PDO::PARAM_STR);
$query->execute();
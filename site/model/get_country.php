<?php

if (!isset($connection)) require_once("db_connection.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$c_name = $request->name;

$query = $connection->prepare("
SELECT *
FROM Countries
WHERE name = :c_name
");

$query->bindValue(':c_name', $c_name, PDO::PARAM_STR);
$query->execute();
echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
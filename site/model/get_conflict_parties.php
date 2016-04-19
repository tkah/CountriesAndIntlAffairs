<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get POSTed in conflict id */
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$c_id = $request->cId;

/* Get conflicts for side A */
$query = $connection->prepare("
    SELECT c.name as countryName, null as partyName
    FROM Countries c, ConflictParties cp
    WHERE cp.conflictId = :c_id
    AND side = 'A'
    AND partyName = c.countryCode
    UNION
    (SELECT null as countryName, partyName as 'partyName'
    FROM ConflictParties
    WHERE side = 'A'
    AND conflictId = :c_id2
    AND partyName NOT IN
    (SELECT countryCode FROM Countries))
");
$query->bindValue(':c_id', $c_id, PDO::PARAM_STR);
$query->bindValue(':c_id2', $c_id, PDO::PARAM_STR);
$query->execute();
$sideA = $query->fetchAll(PDO::FETCH_ASSOC);

/* Get conflicts for side B */
$query = $connection->prepare("
    SELECT c.name as countryName, null as partyName
    FROM Countries c, ConflictParties cp
    WHERE cp.conflictId = :c_id
    AND side = 'B'
    AND partyName = c.countryCode
    UNION
    (SELECT null  as countryName, partyName
    FROM ConflictParties
    WHERE side = 'B'
    AND conflictId = :c_id2
    AND partyName NOT IN
    (SELECT countryCode FROM Countries))
");
$query->bindValue(':c_id', $c_id, PDO::PARAM_STR);
$query->bindValue(':c_id2', $c_id, PDO::PARAM_STR);
$query->execute();
$sideB = $query->fetchAll(PDO::FETCH_ASSOC);

$arr = array();
$arr['sideA'] = $sideA;
$arr['sideB'] = $sideB;

echo json_encode($arr);
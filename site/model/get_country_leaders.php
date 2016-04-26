<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get POSTed in conflict id */
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$c_id = $request->cId;

/* Get conflicts for side A */
$query = $connection->prepare("
    SELECT l.*
    FROM Leaders l, LeaderOf lo
    WHERE lo.countryCode = :c_id
    AND lo.leaderName = l.name
");
$query->bindValue(':c_id', $c_id, PDO::PARAM_STR);
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($res);
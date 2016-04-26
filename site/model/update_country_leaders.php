<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get POSTed in conflict id */
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$leaders = $request->leaders;

foreach ($leaders as $leader) {
    /* Get conflicts for side A */
    $query = $connection->prepare("
        UPDATE Leaders
        SET termEnd = :termEnd
        WHERE name = :c_name
    ");
    $query->bindValue(':termEnd', $leader->termEnd, PDO::PARAM_STR);
    $query->bindValue(':c_name', $leader->name, PDO::PARAM_STR);
    $query->execute();
}
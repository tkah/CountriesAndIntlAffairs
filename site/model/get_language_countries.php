<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get POSTed in language */
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$language = $request->language;

/* Get countries speaking language */
$query = $connection->prepare("
    SELECT c.name, ls.percentPop
    FROM Countries c, LanguagesSpoken ls
    WHERE ls.language = :lang
    AND ls.countryCode = c.countryCode
");
$query->bindValue(':lang', $language, PDO::PARAM_STR);
$query->execute();
$countries = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($countries);
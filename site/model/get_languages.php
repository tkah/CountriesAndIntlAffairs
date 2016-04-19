<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get all languages where first character is capital letter and second character is lower case */
$query = $connection->prepare("
    SELECT language, COUNT(countryCode) as numCountries
    FROM LanguagesSpoken
    WHERE (SUBSTRING(language, 1, 1) COLLATE latin1_bin) = UPPER(SUBSTRING(language, 1, 1))
    AND (SUBSTRING(language, 2, 1) COLLATE latin1_bin ) = LOWER(SUBSTRING(language, 2, 1))
    AND language NOT REGEXP '^[0-9]'
    GROUP BY language
    ORDER BY language

");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($res);
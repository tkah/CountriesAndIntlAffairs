<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get POSTed in country name */
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$c_name = $request->name;

/* Get Countries and Regions table data */
$query = $connection->prepare("
SELECT c.*, r.region
FROM Countries c, Regions r
WHERE c.name = :c_name
AND r.subRegion = c.subregion
");

$query->bindValue(':c_name', $c_name, PDO::PARAM_STR);
$query->execute();
$country = $query->fetchAll(PDO::FETCH_ASSOC);
$country = $country[0];

/* Get LanguagesSpoken table data and assign array to country object */
$query = $connection->prepare("
SELECT language, percentPop
FROM LanguagesSpoken
WHERE countryCode = :c_code
");

$query->bindValue(':c_code', $country['countryCode'], PDO::PARAM_STR);
$query->execute();
$languages = $query->fetchAll(PDO::FETCH_ASSOC);
$country['languages'] = $languages;

/* Get Migrations table data and assign array to country object */
$query = $connection->prepare("
SELECT c.name as origCtry, m.totalAmount as ttlAmt
FROM Countries c, Migrations m
WHERE m.destCountry = :c_num
AND m.origCountry = c.countryNumber
AND inYear = (select max(inYear) from Migrations where destCountry= :c_num2)
ORDER BY m.totalAmount desc
LIMIT 10;
");

$query->bindValue(':c_num', $country['countryNumber'], PDO::PARAM_STR);
$query->bindValue(':c_num2', $country['countryNumber'], PDO::PARAM_STR);
$query->execute();
$immigrants = $query->fetchAll(PDO::FETCH_ASSOC);
$country['immigrants'] = $immigrants;

echo json_encode($country);
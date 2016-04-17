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

$arr = array();
foreach ($conflicts as $conflict) {
    $c = array();
    $c['conflictId'] = $conflict['conflictId'];
    $c['location'] = $conflict['location'];
    $c['start'] = $conflict['start'];
    $c['end'] = $conflict['end'];

    $query = $connection->prepare("
        SELECT c.name
        FROM ConflictParties cp, Countries c
        WHERE countryCode = :c_code
        AND statType = 'co2'
        AND year = (
          SELECT MAX(year)
          FROM WorldBankStats
          WHERE statType = 'co2'
          AND amount <> '0'
        )
    ");
    $query->bindValue(':c_code', $country['countryCode'], PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($res[0])) $c['co2'] = $res[0]['amount'];

    $arr[] = $c;
}


echo json_encode($arr);
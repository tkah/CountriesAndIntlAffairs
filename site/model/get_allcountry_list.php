<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get Countries and Regions table data */
$query = $connection->prepare("
    SELECT c.name, c.countryCode, c.countryNumber, c.subregion, c.govType, r.region, wbs.amount as 'population'
    FROM Countries c, Regions r, WorldBankStats wbs
    WHERE r.subRegion = c.subregion
    AND c.countryCode = wbs.countryCode
    AND wbs.statType = 'population'
    AND wbs.year = '2014'
    ORDER BY c.name ASC
");
$query->execute();
$countries = $query->fetchAll(PDO::FETCH_ASSOC);

$arr = array();
foreach ($countries as $country) {
    $c = array();
    $c['name'] = $country['name'];
    $c['subregion'] = $country['subregion'];
    $c['region'] = $country['region'];
    $c['govType'] = $country['govType'];
    $c['population'] = $country['population'];
    $c['countryNumber'] = $country['countryNumber'];

    $query = $connection->prepare("
        SELECT amount
        FROM WorldBankStats
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

    $query = $connection->prepare("
        SELECT amount
        FROM WorldBankStats
        WHERE countryCode = :c_code
        AND statType = 'expectancy'
        AND year = (
          SELECT MAX(year)
          FROM WorldBankStats
          WHERE statType = 'expectancy'
          AND amount <> '0'
        )
    ");
    $query->bindValue(':c_code', $country['countryCode'], PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($res[0])) $c['expectancy'] = $res[0]['amount'];

    $query = $connection->prepare("
        SELECT amount
        FROM WorldBankStats
        WHERE countryCode = :c_code
        AND statType = 'gdp'
        AND year = (
          SELECT MAX(year)
          FROM WorldBankStats
          WHERE statType = 'gdp'
          AND amount <> '0'
        )
    ");
    $query->bindValue(':c_code', $country['countryCode'], PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($res[0])) $c['gdp'] = $res[0]['amount'];

    $query = $connection->prepare("
        SELECT SUM(totalAmount) as 'total'
        FROM Migrations
        WHERE destCountry = :c_num
        AND inYear = '2015'
    ");
    $query->bindValue(':c_num', $country['countryNumber'], PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($res[0])) $c['immigration'] = $res[0]['total'];

    $query = $connection->prepare("
        SELECT SUM(totalAmount) as 'total'
        FROM Migrations
        WHERE origCountry = :c_num
        AND inYear = '2015'
    ");
    $query->bindValue(':c_num', $country['countryNumber'], PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($res[0])) $c['emigration'] = $res[0]['total'];

    $arr[] = $c;
}


echo json_encode($arr);
<?php

/* Conflicts since 1946
   http://www.pcr.uu.se/research/ucdp/datasets/ucdp_prio_armed_conflict_dataset/
 */

if (!isset($conn)) require_once("db_connection.php");

$csvFile = file("../db_resources/population.csv");
for ($i = 1; $i < sizeof($csvFile); $i++) {
    //$data[] = str_getcsv($line);
    $contents = explode(",", $csvFile[$i]);

    $query = $conn->prepare("
          SELECT countryCode
          FROM Countries
          WHERE name = :p_name
        ");

    $query->bindValue(':p_name', utf8_encode($contents[0]), PDO::PARAM_STR);
    $query->execute();
    $c_code = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($c_code && ($contents[1] != ".." || $contents[2] != ".." || $contents[3] != ".." || $contents[4] != ".." || $contents[5] != ".." || $contents[6] != ".." || $contents[7] != ".." || $contents[8] != ".." || $contents[9] != ".." || $contents[10] != "..")) {
        $name = $c_code[0]['countryCode'];
        $isCountry = 1;

        $q_string = "INSERT IGNORE INTO WorldBankStats (countryCode, statType";
        if ($contents[1] != "..") $q_string .= ", year2005";
        if ($contents[2] != "..") $q_string .= ", year2006";
        if ($contents[3] != "..") $q_string .= ", year2007";
        if ($contents[4] != "..") $q_string .= ", year2008";
        if ($contents[5] != "..") $q_string .= ", year2009";
        if ($contents[6] != "..") $q_string .= ", year2010";
        if ($contents[7] != "..") $q_string .= ", year2011";
        if ($contents[8] != "..") $q_string .= ", year2012";
        if ($contents[9] != "..") $q_string .= ", year2013";
        if ($contents[10] != "..") $q_string .= ", year2014";
        $q_string .= ") VALUES (:c_id, 'population'";
        if ($contents[1] != "..") $q_string .= ", :year2005";
        if ($contents[2] != "..") $q_string .= ", :year2006";
        if ($contents[3] != "..") $q_string .= ", :year2007";
        if ($contents[4] != "..") $q_string .= ", :year2008";
        if ($contents[5] != "..") $q_string .= ", :year2009";
        if ($contents[6] != "..") $q_string .= ", :year2010";
        if ($contents[7] != "..") $q_string .= ", :year2011";
        if ($contents[8] != "..") $q_string .= ", :year2012";
        if ($contents[9] != "..") $q_string .= ", :year2013";
        if ($contents[10] != "..") $q_string .= ", :year2014";
        $q_string .= ")";

        $query = $conn->prepare($q_string);

        $query->bindValue(':c_id', $name, PDO::PARAM_STR);
        if ($contents[1] != "..") $query->bindValue(':year2005', $contents[1], PDO::PARAM_STR);
        if ($contents[2] != "..") $query->bindValue(':year2006', $contents[2], PDO::PARAM_STR);
        if ($contents[3] != "..") $query->bindValue(':year2007', $contents[3], PDO::PARAM_STR);
        if ($contents[4] != "..") $query->bindValue(':year2008', $contents[4], PDO::PARAM_STR);
        if ($contents[5] != "..") $query->bindValue(':year2009', $contents[5], PDO::PARAM_STR);
        if ($contents[6] != "..") $query->bindValue(':year2010', $contents[6], PDO::PARAM_STR);
        if ($contents[7] != "..") $query->bindValue(':year2011', $contents[7], PDO::PARAM_STR);
        if ($contents[8] != "..") $query->bindValue(':year2012', $contents[8], PDO::PARAM_STR);
        if ($contents[9] != "..") $query->bindValue(':year2013', $contents[9], PDO::PARAM_STR);
        if ($contents[10] != "..") $query->bindValue(':year2014', $contents[10], PDO::PARAM_STR);
        $query->execute();
    }

    echo "<br>" . $contents[0] . "<br>";
    echo "2005: " . $contents[1] . "<br>";
    echo "2006: " . $contents[2] . "<br>";
    echo "2007: " . $contents[3] . "<br>";
    echo "2008: " . $contents[4] . "<br>";
    echo "2009: " . $contents[5] . "<br>";
    echo "2010: " . $contents[6] . "<br>";
    echo "2011: " . $contents[7] . "<br>";
    echo "2012: " . $contents[8] . "<br>";
    echo "2013: " . $contents[9] . "<br>";
    echo "2014: " . $contents[10] . "<br>";
}

$csvFile = file("../db_resources/co2.csv");
for ($i = 1; $i < sizeof($csvFile); $i++) {
    //$data[] = str_getcsv($line);
    $contents = explode(",", $csvFile[$i]);

    $query = $conn->prepare("
          SELECT countryCode
          FROM Countries
          WHERE name = :p_name
        ");

    $query->bindValue(':p_name', utf8_encode($contents[0]), PDO::PARAM_STR);
    $query->execute();
    $c_code = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($c_code && ($contents[1] != ".." || $contents[2] != ".." || $contents[3] != ".." || $contents[4] != ".." || $contents[5] != ".." || $contents[6] != ".." || $contents[7] != ".." || $contents[8] != ".." || $contents[9] != ".." || $contents[10] != "..")) {
        $name = $c_code[0]['countryCode'];
        $isCountry = 1;

        $q_string = "INSERT IGNORE INTO WorldBankStats (countryCode, statType";
        if ($contents[1] != "..") $q_string .= ", year2005";
        if ($contents[2] != "..") $q_string .= ", year2006";
        if ($contents[3] != "..") $q_string .= ", year2007";
        if ($contents[4] != "..") $q_string .= ", year2008";
        if ($contents[5] != "..") $q_string .= ", year2009";
        if ($contents[6] != "..") $q_string .= ", year2010";
        if ($contents[7] != "..") $q_string .= ", year2011";
        if ($contents[8] != "..") $q_string .= ", year2012";
        if ($contents[9] != "..") $q_string .= ", year2013";
        if ($contents[10] != "..") $q_string .= ", year2014";
        $q_string .= ") VALUES (:c_id, 'co2'";
        if ($contents[1] != "..") $q_string .= ", :year2005";
        if ($contents[2] != "..") $q_string .= ", :year2006";
        if ($contents[3] != "..") $q_string .= ", :year2007";
        if ($contents[4] != "..") $q_string .= ", :year2008";
        if ($contents[5] != "..") $q_string .= ", :year2009";
        if ($contents[6] != "..") $q_string .= ", :year2010";
        if ($contents[7] != "..") $q_string .= ", :year2011";
        if ($contents[8] != "..") $q_string .= ", :year2012";
        if ($contents[9] != "..") $q_string .= ", :year2013";
        if ($contents[10] != "..") $q_string .= ", :year2014";
        $q_string .= ")";

        $query = $conn->prepare($q_string);

        $query->bindValue(':c_id', $name, PDO::PARAM_STR);
        if ($contents[1] != "..") $query->bindValue(':year2005', $contents[1], PDO::PARAM_STR);
        if ($contents[2] != "..") $query->bindValue(':year2006', $contents[2], PDO::PARAM_STR);
        if ($contents[3] != "..") $query->bindValue(':year2007', $contents[3], PDO::PARAM_STR);
        if ($contents[4] != "..") $query->bindValue(':year2008', $contents[4], PDO::PARAM_STR);
        if ($contents[5] != "..") $query->bindValue(':year2009', $contents[5], PDO::PARAM_STR);
        if ($contents[6] != "..") $query->bindValue(':year2010', $contents[6], PDO::PARAM_STR);
        if ($contents[7] != "..") $query->bindValue(':year2011', $contents[7], PDO::PARAM_STR);
        if ($contents[8] != "..") $query->bindValue(':year2012', $contents[8], PDO::PARAM_STR);
        if ($contents[9] != "..") $query->bindValue(':year2013', $contents[9], PDO::PARAM_STR);
        if ($contents[10] != "..") $query->bindValue(':year2014', $contents[10], PDO::PARAM_STR);
        $query->execute();
    }
}

$csvFile = file("../db_resources/expectancy.csv");
for ($i = 1; $i < sizeof($csvFile); $i++) {
    //$data[] = str_getcsv($line);
    $contents = explode(",", $csvFile[$i]);

    $query = $conn->prepare("
          SELECT countryCode
          FROM Countries
          WHERE name = :p_name
        ");

    $query->bindValue(':p_name', utf8_encode($contents[0]), PDO::PARAM_STR);
    $query->execute();
    $c_code = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($c_code && ($contents[1] != ".." || $contents[2] != ".." || $contents[3] != ".." || $contents[4] != ".." || $contents[5] != ".." || $contents[6] != ".." || $contents[7] != ".." || $contents[8] != ".." || $contents[9] != ".." || $contents[10] != "..")) {
        $name = $c_code[0]['countryCode'];
        $isCountry = 1;

        $q_string = "INSERT IGNORE INTO WorldBankStats (countryCode, statType";
        if ($contents[1] != "..") $q_string .= ", year2005";
        if ($contents[2] != "..") $q_string .= ", year2006";
        if ($contents[3] != "..") $q_string .= ", year2007";
        if ($contents[4] != "..") $q_string .= ", year2008";
        if ($contents[5] != "..") $q_string .= ", year2009";
        if ($contents[6] != "..") $q_string .= ", year2010";
        if ($contents[7] != "..") $q_string .= ", year2011";
        if ($contents[8] != "..") $q_string .= ", year2012";
        if ($contents[9] != "..") $q_string .= ", year2013";
        if ($contents[10] != "..") $q_string .= ", year2014";
        $q_string .= ") VALUES (:c_id, 'expectancy'";
        if ($contents[1] != "..") $q_string .= ", :year2005";
        if ($contents[2] != "..") $q_string .= ", :year2006";
        if ($contents[3] != "..") $q_string .= ", :year2007";
        if ($contents[4] != "..") $q_string .= ", :year2008";
        if ($contents[5] != "..") $q_string .= ", :year2009";
        if ($contents[6] != "..") $q_string .= ", :year2010";
        if ($contents[7] != "..") $q_string .= ", :year2011";
        if ($contents[8] != "..") $q_string .= ", :year2012";
        if ($contents[9] != "..") $q_string .= ", :year2013";
        if ($contents[10] != "..") $q_string .= ", :year2014";
        $q_string .= ")";

        $query = $conn->prepare($q_string);

        $query->bindValue(':c_id', $name, PDO::PARAM_STR);
        if ($contents[1] != "..") $query->bindValue(':year2005', $contents[1], PDO::PARAM_STR);
        if ($contents[2] != "..") $query->bindValue(':year2006', $contents[2], PDO::PARAM_STR);
        if ($contents[3] != "..") $query->bindValue(':year2007', $contents[3], PDO::PARAM_STR);
        if ($contents[4] != "..") $query->bindValue(':year2008', $contents[4], PDO::PARAM_STR);
        if ($contents[5] != "..") $query->bindValue(':year2009', $contents[5], PDO::PARAM_STR);
        if ($contents[6] != "..") $query->bindValue(':year2010', $contents[6], PDO::PARAM_STR);
        if ($contents[7] != "..") $query->bindValue(':year2011', $contents[7], PDO::PARAM_STR);
        if ($contents[8] != "..") $query->bindValue(':year2012', $contents[8], PDO::PARAM_STR);
        if ($contents[9] != "..") $query->bindValue(':year2013', $contents[9], PDO::PARAM_STR);
        if ($contents[10] != "..") $query->bindValue(':year2014', $contents[10], PDO::PARAM_STR);
        $query->execute();
    }
}

$csvFile = file("../db_resources/gdp.csv");
for ($i = 1; $i < sizeof($csvFile); $i++) {
    //$data[] = str_getcsv($line);
    $contents = explode(",", $csvFile[$i]);

    $query = $conn->prepare("
          SELECT countryCode
          FROM Countries
          WHERE name = :p_name
        ");

    $query->bindValue(':p_name', utf8_encode($contents[0]), PDO::PARAM_STR);
    $query->execute();
    $c_code = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($c_code && ($contents[1] != ".." || $contents[2] != ".." || $contents[3] != ".." || $contents[4] != ".." || $contents[5] != ".." || $contents[6] != ".." || $contents[7] != ".." || $contents[8] != ".." || $contents[9] != ".." || $contents[10] != "..")) {
        $name = $c_code[0]['countryCode'];
        $isCountry = 1;

        $q_string = "INSERT IGNORE INTO WorldBankStats (countryCode, statType";
        if ($contents[1] != "..") $q_string .= ", year2005";
        if ($contents[2] != "..") $q_string .= ", year2006";
        if ($contents[3] != "..") $q_string .= ", year2007";
        if ($contents[4] != "..") $q_string .= ", year2008";
        if ($contents[5] != "..") $q_string .= ", year2009";
        if ($contents[6] != "..") $q_string .= ", year2010";
        if ($contents[7] != "..") $q_string .= ", year2011";
        if ($contents[8] != "..") $q_string .= ", year2012";
        if ($contents[9] != "..") $q_string .= ", year2013";
        if ($contents[10] != "..") $q_string .= ", year2014";
        $q_string .= ") VALUES (:c_id, 'gdp'";
        if ($contents[1] != "..") $q_string .= ", :year2005";
        if ($contents[2] != "..") $q_string .= ", :year2006";
        if ($contents[3] != "..") $q_string .= ", :year2007";
        if ($contents[4] != "..") $q_string .= ", :year2008";
        if ($contents[5] != "..") $q_string .= ", :year2009";
        if ($contents[6] != "..") $q_string .= ", :year2010";
        if ($contents[7] != "..") $q_string .= ", :year2011";
        if ($contents[8] != "..") $q_string .= ", :year2012";
        if ($contents[9] != "..") $q_string .= ", :year2013";
        if ($contents[10] != "..") $q_string .= ", :year2014";
        $q_string .= ")";

        $query = $conn->prepare($q_string);

        $query->bindValue(':c_id', $name, PDO::PARAM_STR);
        if ($contents[1] != "..") $query->bindValue(':year2005', $contents[1], PDO::PARAM_STR);
        if ($contents[2] != "..") $query->bindValue(':year2006', $contents[2], PDO::PARAM_STR);
        if ($contents[3] != "..") $query->bindValue(':year2007', $contents[3], PDO::PARAM_STR);
        if ($contents[4] != "..") $query->bindValue(':year2008', $contents[4], PDO::PARAM_STR);
        if ($contents[5] != "..") $query->bindValue(':year2009', $contents[5], PDO::PARAM_STR);
        if ($contents[6] != "..") $query->bindValue(':year2010', $contents[6], PDO::PARAM_STR);
        if ($contents[7] != "..") $query->bindValue(':year2011', $contents[7], PDO::PARAM_STR);
        if ($contents[8] != "..") $query->bindValue(':year2012', $contents[8], PDO::PARAM_STR);
        if ($contents[9] != "..") $query->bindValue(':year2013', $contents[9], PDO::PARAM_STR);
        if ($contents[10] != "..") $query->bindValue(':year2014', $contents[10], PDO::PARAM_STR);
        $query->execute();
    }
}
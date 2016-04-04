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

        $year = 2005;
        foreach ($contents as $key => $value) {
            if ($key == 0) continue;
            if ($value == "..") {
                $year += 1;
                continue;
            }
            $query = $conn->prepare("
                INSERT INTO WorldBankStats (countryCode, statType, year, amount)
                VALUES (:code, 'population', :year, :amt)
            ");
            $query->bindValue(':code', $name, PDO::PARAM_STR);
            $query->bindValue(':year', $year, PDO::PARAM_STR);
            $query->bindValue(':amt', $value, PDO::PARAM_STR);
            $query->execute();

            $year += 1;
            
        }
    }
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

        $year = 2005;

        foreach ($contents as $key => $value) {
            if ($key == 0) continue;
            if ($value == "..") {
                $year += 1;
                continue;
            }
            $query = $conn->prepare("
                INSERT INTO WorldBankStats (countryCode, statType, year, amount)
                VALUES (:code, 'co2', :year, :amt)
            ");

            $query->bindValue(':code', $name, PDO::PARAM_STR);
            $query->bindValue(':year', $year, PDO::PARAM_STR);
            $query->bindValue(':amt', $value, PDO::PARAM_STR);
            $query->execute();

            $year += 1;
        }
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

        $year = 2005;

        foreach ($contents as $key => $value) {
            if ($key == 0) continue;
            if ($value == "..") {
                $year += 1;
                continue;
            }
            $query = $conn->prepare("
                INSERT INTO WorldBankStats (countryCode, statType, year, amount)
                VALUES (:code, 'expectancy', :year, :amt)
            ");

            $query->bindValue(':code', $name, PDO::PARAM_STR);
            $query->bindValue(':year', $year, PDO::PARAM_STR);
            $query->bindValue(':amt', $value, PDO::PARAM_STR);
            $query->execute();

            $year += 1;
        }
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

        $year = 2005;

        foreach ($contents as $key => $value) {
            if ($key == 0) continue;

            if ($value == "..") {
                $year += 1;
                continue;
            }
            $query = $conn->prepare("
                INSERT INTO WorldBankStats (countryCode, statType, year, amount)
                VALUES (:code, 'gdp', :year, :amt)
            ");

            $query->bindValue(':code', $name, PDO::PARAM_STR);
            $query->bindValue(':year', $year, PDO::PARAM_STR);
            $query->bindValue(':amt', $value, PDO::PARAM_STR);
            $query->execute();

            $year += 1;
        }
    }
}

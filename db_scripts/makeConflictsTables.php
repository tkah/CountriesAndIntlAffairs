<?php

/* Conflicts since 1946
   http://www.pcr.uu.se/research/ucdp/datasets/ucdp_prio_armed_conflict_dataset/
 */

if (!isset($conn)) require_once("db_connection.php");

$sql = "CREATE TABLE Conflicts (
    conflictId VARCHAR(10) PRIMARY KEY,
    location VARCHAR(50),
    start VARCHAR(10),
    end VARCHAR(10)
    )";

// use exec() because no results are returned
$conn->exec($sql);

$sql = "CREATE TABLE ConflictParties (
    conflictId VARCHAR(10),
    partyName VARCHAR(100),
    side VARCHAR(1),
    isCountry INT(1),
    PRIMARY KEY (conflictId, partyName)
    )";

// use exec() because no results are returned
$conn->exec($sql);

$csvFile = file("../db_resources/124920_1ucdpprio-armed-conflict-dataset-v.4-2015.csv");

$sameId = false;
$sameYearId = false;
$prevStartYear = 0;
$endYear = 0;
$a2 = array();
$barr = array();
$b2 = array();
$append = 1;

$data = [];
for ($i = 1; $i < sizeof($csvFile); $i++) {
    //$data[] = str_getcsv($line);
    $contents = explode(",", $csvFile[$i]);

    $conflictIdNoApp = trim($contents[0]);
    $startYear = trim($contents[1]);

    if ($i == 1) $prevStartYear = $startYear;

    $conflictId = $conflictIdNoApp . "-" . $append;

    if ($csvFile[$i + 1]) {
        $next = explode(",", $csvFile[$i + 1]);
        if ($startYear == trim($next[1]) - 1 && $conflictIdNoApp == trim($next[0])) {
            //echo "next year<br>";
            $sameYearId = true;
            $sameId = false;
            $startYear = $prevStartYear;
        } elseif ($conflictIdNoApp == trim($next[0])) {
            //echo "same id<br>";
            $sameId = true;
            $sameYearId = false;
            $endYear = $startYear;
            //$a2 = array();
            //$barr = array();
            //$b2 = array();
            $append += 1;
            $startYear = $prevStartYear;
            $prevStartYear = trim($next[1]);
        } else {
            //echo "else<br>";
            $append = 1;
            $endYear = $startYear;
            $sameId = false;
            $sameYearId = false;
            $startYear = $prevStartYear;
            $prevStartYear = trim($next[1]);
        }
    } else {
        $startYear = $prevStartYear;
        $sameYearId = false;
    }

    if ($sameYearId) $prevStartYear = $startYear;

    $location = str_replace('"', "", $contents[2]);

    $sideA = str_replace("Government of ", "", $contents[3]);
    if (strpos($sideA, " (") !== false) {
        $start = strpos($sideA, " (");
        $sideA = substr($sideA, 0, $start);
    }
    $sideA = trim(str_replace('"', "", $sideA));
    if ($sideA == "United States of America") $sideA = "United States";

    $sideA2 = explode(";", $contents[4]);
    foreach ($sideA2 as $a) {
        $name = $a;
        if (strpos($a, "Government of ") !== false) {
            $name = str_replace("Government of ", "", $a);
            if (strpos($name, " (") !== false) {
                $start = strpos($name, " (");
                $name = substr($name, 0, $start);
            }
        }
        $name = trim(str_replace('"', "", $name));
        if ($name == "United States of America") $name = "United States";
        array_push($a2, $name);
    }

    $sideB = explode(";", $contents[5]);
    foreach ($sideB as $b) {
        $name = $b;
        if (strpos($b, "Government of ") !== false) {
            $name = str_replace("Government of ", "", $b);
            if (strpos($name, " (") !== false) {
                $start = strpos($name, " (");
                $name = substr($name, 0, $start);
            }
        }
        $name = trim(str_replace('"', "", $name));
        if ($name == "United States of America") $name = "United States";
        array_push($barr, $name);
    }

    $sideB2 = explode(";", $contents[7]);
    foreach ($sideB2 as $b) {
        $name = $b;
        if (strpos($b, "Government of ") !== false) {
            $name = str_replace("Government of ", "", $b);
            if (strpos($name, " (") !== false) {
                $start = strpos($name, " (");
                $name = substr($name, 0, $start);
            }
        }
        $name = trim(str_replace('"', "", $name));
        if ($name == "United States of America") $name = "United States";
        if (!ctype_digit(trim($name))) array_push($b2, $name);
    }

    if (!$sameYearId) {
        $query = $conn->prepare("
            INSERT INTO Conflicts (conflictId, location, start, end)
            VALUES (:c_id, :loc, :start, :end)
        ");

        $query->bindValue(':c_id', $conflictId, PDO::PARAM_STR);
        $query->bindValue(':loc', $location, PDO::PARAM_STR);
        $query->bindValue(':start', $startYear, PDO::PARAM_STR);
        $query->bindValue(':end', $endYear, PDO::PARAM_STR);
        $query->execute();


        $query = $conn->prepare("
          SELECT countryCode
          FROM Countries
          WHERE name = :p_name
        ");

        $query->bindValue(':p_name', utf8_encode($sideA), PDO::PARAM_STR);
        $query->execute();
        $c_code = $query->fetchAll(PDO::FETCH_ASSOC);

        $isCountry = 0;
        if ($c_code) {
            $name = $c_code[0]['countryCode'];
            $isCountry = 1;
        }

        if ($name && strlen($name) > 1) {
            $query = $conn->prepare("
                    INSERT IGNORE INTO ConflictParties (conflictId, partyName, side, isCountry)
                    VALUES (:c_id, :party, 'A', :isCountry)
                ");

            $query->bindValue(':c_id', $conflictId, PDO::PARAM_STR);
            $query->bindValue(':party', utf8_encode($name), PDO::PARAM_STR);
            $query->bindValue(':isCountry', $isCountry, PDO::PARAM_STR);
            $query->execute();
        }

        foreach ($a2 as $name) {
            $query = $conn->prepare("
                      SELECT countryCode
                      FROM Countries
                      WHERE name = :p_name
                    ");

            $query->bindValue(':p_name', utf8_encode($name), PDO::PARAM_STR);
            $query->execute();
            $c_code = $query->fetchAll(PDO::FETCH_ASSOC);

            $isCountry = 0;
            if ($c_code) {
                $name = $c_code[0]['countryCode'];
                $isCountry = 1;
            }

            if ($name && strlen($name) > 1) {
                $query = $conn->prepare("
                    INSERT IGNORE INTO ConflictParties (conflictId, partyName, side, isCountry)
                    VALUES (:c_id, :party, 'A', :isCountry)
                ");

                $query->bindValue(':c_id', $conflictId, PDO::PARAM_STR);
                $query->bindValue(':party', utf8_encode($name), PDO::PARAM_STR);
                $query->bindValue(':isCountry', $isCountry, PDO::PARAM_STR);
                $query->execute();
            }
        }

        foreach ($barr as $name) {
            $query = $conn->prepare("
                      SELECT countryCode
                      FROM Countries
                      WHERE name = :p_name
                    ");

            $query->bindValue(':p_name', utf8_encode($name), PDO::PARAM_STR);
            $query->execute();
            $c_code = $query->fetchAll(PDO::FETCH_ASSOC);

            $isCountry = 0;
            if ($c_code) {
                $name = $c_code[0]['countryCode'];
                $isCountry = 1;
            }

            if ($name && strlen($name) > 1) {
                $query = $conn->prepare("
                    INSERT IGNORE INTO ConflictParties (conflictId, partyName, side, isCountry)
                    VALUES (:c_id, :party, 'B', :isCountry)
                ");

                $query->bindValue(':c_id', $conflictId, PDO::PARAM_STR);
                $query->bindValue(':party', utf8_encode($name), PDO::PARAM_STR);
                $query->bindValue(':isCountry', $isCountry, PDO::PARAM_STR);
                $query->execute();
            }
        }

        foreach ($b2 as $name) {
            $query = $conn->prepare("
                      SELECT countryCode
                      FROM Countries
                      WHERE name = :p_name
                    ");

            $query->bindValue(':p_name', utf8_encode($name), PDO::PARAM_STR);
            $query->execute();
            $c_code = $query->fetchAll(PDO::FETCH_ASSOC);

            $isCountry = 0;
            if ($c_code) {
                $name = $c_code[0]['countryCode'];
                $isCountry = 1;
            }

            if ($name && strlen($name) > 1) {
                $query = $conn->prepare("
                    INSERT IGNORE INTO ConflictParties (conflictId, partyName, side, isCountry)
                    VALUES (:c_id, :party, 'B', :isCountry)
                ");

                $query->bindValue(':c_id', $conflictId, PDO::PARAM_STR);
                $query->bindValue(':party', utf8_encode($name), PDO::PARAM_STR);
                $query->bindValue(':isCountry', $isCountry, PDO::PARAM_STR);
                $query->execute();
            }
        }
    }

    /*
    echo $conflictId . "<br>";
    echo "--------------------<br>";
    echo $startYear . " " . $location . "<br>";
    echo "A: " . $sideA . "<br>";

    echo "A Support: ";
    foreach ($a2 as $a) echo $a . " ";
    echo "<br>";
    echo "B: ";
    foreach ($barr as $bstring) echo $bstring . " ";
    echo "<br>";
    echo "B Support: ";
    foreach ($b2 as $bstring) echo $bstring . " ";
    echo "<br><br>";
    */

    if (!$sameYearId) {
        $a2 = array();
        $barr = array();
        $b2 = array();
    }
}
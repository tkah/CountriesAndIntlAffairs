<?php
/**
 * Created by IntelliJ IDEA.
 * User: T-Drive
 * Date: 3/3/16
 * Time: 7:59 PM
 */

if (!isset($conn)) require_once("db_connection.php");
//1.drop existing table
$sql = "DROP TABLE if exists Borders";
$conn->exec($sql);

//2.create table Borders
$sql = "CREATE TABLE Borders (
    countryCode VARCHAR(3),
    borderingCountryCode VARCHAR(3),
    PRIMARY KEY (countryCode, borderingCountryCode)
    )";

// use exec() because no results are returned
$conn->exec($sql);

$file_json = file_get_contents("../db_resources/countries.json");
$file = json_decode($file_json, true);
//$outputf = '/var/tmp/insertBorder.sql';
foreach ($file as $country) {
    foreach ($country["borders"] as $border) {
        //$ctry_code=$country["cca3"];
        //$stmt = "INSERT INTO Borders (countryCode, borderingCountryCode)".
        //        "VALUES ('$ctry_code', '$border');"."\n";
        $query = $conn->prepare("
            INSERT INTO Borders (countryCode, borderingCountryCode)
            VALUES (:code, :b_code)
        ");

        $query->bindValue(':code', $country["cca3"], PDO::PARAM_STR);
        $query->bindValue(':b_code', $border, PDO::PARAM_STR);
        $query->execute();
        //print($stmt."\n");
        //file_put_contents($outputf, $stmt, FILE_APPEND);
    }
}

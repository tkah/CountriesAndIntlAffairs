<?php
/**
 * Created by IntelliJ IDEA.
 * User: T-Drive
 * Date: 3/3/16
 * Time: 7:59 PM
 */

if (!isset($conn)) require_once("db_connection.php");

$file_json = file_get_contents("../db_resources/countries.json");
$file = json_decode($file_json, true);

foreach ($file as $country) {
    foreach ($country["borders"] as $border) {
        $query = $conn->prepare("
            INSERT INTO Borders (countryCode, borderingCountryCode)
            VALUES (:code, :b_code)
        ");

        $query->bindValue(':code', $country["cca3"], PDO::PARAM_STR);
        $query->bindValue(':b_code', $border, PDO::PARAM_STR);
        $query->execute();
    }
}
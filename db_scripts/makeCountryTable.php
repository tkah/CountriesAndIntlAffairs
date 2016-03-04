<?php
/**
 * Created by IntelliJ IDEA.
 * User: T-Drive
 * Date: 3/4/16
 * Time: 3:00 PM
 */

if (!isset($conn)) require_once("db_connection.php");

$sql = "CREATE TABLE Countries (
    countryCode VARCHAR(3) PRIMARY KEY,
    name VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    region VARCHAR(100) NOT NULL,
    subregion VARCHAR(100) NOT NULL,
    capital VARCHAR(50) NOT NULL
    )";

// use exec() because no results are returned
$conn->exec($sql);

$file_json = file_get_contents("../db_resources/countries-unescaped.json");
$file = json_decode($file_json, true);

foreach ($file as $country) {

    $query = $conn->prepare("
        INSERT INTO Countries (countryCode, name, region, subregion, capital)
        VALUES (:code, :name, :region, :subregion, :capital)
    ");

    $query->bindValue(':code', $country["cca3"], PDO::PARAM_STR);
    $query->bindValue(':name', $country["name"]["common"], PDO::PARAM_STR);
    $query->bindValue(':region', $country["region"], PDO::PARAM_STR);
    $query->bindValue(':subregion', $country["subregion"], PDO::PARAM_STR);
    $query->bindValue(':capital', $country["capital"], PDO::PARAM_STR);
    $query->execute();
}
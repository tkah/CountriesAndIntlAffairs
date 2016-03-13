<?php
/**
 * Created by IntelliJ IDEA.
 * User: T-Drive
 * Date: 3/4/16
 * Time: 3:00 PM
 */

if (!isset($conn)) require_once("db_connection.php");
include('simple_html_dom.php');

//1.drop existing table
$sql = "DROP TABLE if exists Countries";
$conn->exec($sql);

//2.create table Countries
$sql = "CREATE TABLE Countries (
    countryCode VARCHAR(3) PRIMARY KEY,
    countryNumber VARCHAR(3) NOT NULL,
    name VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    subregion VARCHAR(100),
    capital VARCHAR(50),
    factbookCode VARCHAR(2),
    generalInfo TEXT,
    climate TEXT,
    govType TEXT,
    economy TEXT,
    UNIQUE KEY(countryNumber)
    )";

// use exec() because no results are returned
$conn->exec($sql);

$file_json = file_get_contents("../db_resources/countries-unescaped.json");
$file = json_decode($file_json, true);
foreach ($file as $country) {

    $query = $conn->prepare("
        INSERT INTO Countries (countryCode, countryNumber,name, subregion, capital)
        VALUES (:code, :number, :name, :subregion, :capital)
    ");
    $query->bindValue(':code', $country["cca3"], PDO::PARAM_STR);
    $query->bindValue(':number', $country["ccn3"], PDO::PARAM_STR);
    $query->bindValue(':name', $country["name"]["common"], PDO::PARAM_STR);
    $query->bindValue(':subregion', $country["subregion"], PDO::PARAM_STR);
    $query->bindValue(':capital', $country["capital"], PDO::PARAM_STR);
    $query->execute();
}

$dir = new DirectoryIterator(dirname("../db_resources/geos/aa.html"));
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $factbookCode = substr($fileinfo->getFilename(), 0, 2);

        $html = file_get_html("../db_resources/geos/" . $fileinfo->getFilename());
        // Name
        $factbookName = $html->find('h2[sectiontitle=Introduction]', 0)->children(0)->children(0)->innertext;

        $query = $conn->prepare("
                      SELECT countryCode
                      FROM Countries
                      WHERE name = :f_name
                    ");

        $query->bindValue(':f_name', $factbookName, PDO::PARAM_STR);
        $query->execute();
        $p_code = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($p_code) {
            $p_code = $p_code[0]['countryCode'];

            // Desc
            $factbookDesc = $html->find('h2[sectiontitle=Introduction]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->children(0)->children(0)->innertext;
            // Climate
            $factbookClimate = $html->find('h2[sectiontitle=Geography]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->innertext;
            // Gov Type
            $factbookGovType = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->innertext;
            // Economy
            $factbookEcon = $html->find('h2[sectiontitle=Economy]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->children(0)->children(0)->innertext;

            $query = $conn->prepare("
                UPDATE Countries SET
                factbookCode = :f_code,
                generalInfo = :info,
                climate = :climate,
                govType = :type,
                economy = :economy
                WHERE countryCode = :p_code
            ");

            $query->bindValue(':f_code', $factbookCode, PDO::PARAM_STR);
            $query->bindValue(':info', $factbookDesc, PDO::PARAM_STR);
            $query->bindValue(':climate', $factbookClimate, PDO::PARAM_STR);
            $query->bindValue(':type', $factbookGovType, PDO::PARAM_STR);
            $query->bindValue(':economy', $factbookEcon, PDO::PARAM_STR);
            $query->bindValue(':p_code', $p_code, PDO::PARAM_STR);
            $query->execute();
        }
    }
}

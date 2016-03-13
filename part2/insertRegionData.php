<?php
/**
 * Created by IntelliJ IDEA.
 * User: T-Drive
 * Date: 3/4/16
 * Time: 3:00 PM
 */

if (!isset($conn)) require_once("db_connection.php");
include('simple_html_dom.php');

$file_json = file_get_contents("../db_resources/countries-unescaped.json");
$file = json_decode($file_json, true);

foreach ($file as $country) {
    try{
      $query = $conn->prepare("
          INSERT INTO Regions (subRegion, region)
          VALUES (:subregion, :region)
      ");

      $query->bindValue(':region', $country["region"], PDO::PARAM_STR);
      $query->bindValue(':subregion', $country["subregion"], PDO::PARAM_STR);
      if ($country["subregion"]){ 
        $query->execute();
      }
    }
    catch(PDOException $e){
      $e->getMessage();
    }
}



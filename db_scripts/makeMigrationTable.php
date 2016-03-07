<?php
/**
 * Created by IntelliJ IDEA.
 * User: T-Drive
 * Date: 3/4/16
 * Time: 3:00 PM
 */

if (!isset($conn)) require_once("db_connection.php");

$sql = "DROP TABLE Migrations";
$conn->exec($sql);

$sql = "CREATE TABLE Migrations (
    destCountry VARCHAR(3),
    origCountry VARCHAR(3),
    inYear           VARCHAR(4), 
    totalAmount      DECIMAL(8)  NOT NULL,
    PRIMARY KEY(destCountry,origCountry,inYear)
    )";

// use exec() because no results are returned
$conn->exec($sql);

$file_csv = "../db_resources/mig.csv";
if (($handle = fopen($file_csv, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $sql = "INSERT INTO Migrations ( destCountry, origCountry, inYear, totalAmount) VALUES ( '".mysql_escape_string($data[0])."','".mysql_escape_string($data[1])."','".mysql_escape_string($data[2])."','".mysql_escape_string($data[3])."')";
        $query = $conn->query($sql);
        if($query){
            echo "row inserted\n";
        }
        else{
            echo die(mysql_error());
        }
    }
    fclose($handle);
}
?>


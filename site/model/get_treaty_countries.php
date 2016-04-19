<?php

if (!isset($connection)) require_once("db_connection.php");

/* Get POSTed in treaty number */
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$treatyNum = $request->treatyNum;

/* Get countries who signed onto treaty */
$query = $connection->prepare("
    SELECT c.name
    FROM Countries c, TreatyParties tp
    WHERE tp.treatyNumber = :t_num
    AND tp.countryNumber = c.countryNumber
    ORDER BY c.name
");
$query->bindValue(':t_num', $treatyNum, PDO::PARAM_STR);
$query->execute();
$countries = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($countries);
<?php

/* Top Five Trade Partners
   http://wits.worldbank.org/datadownload.aspx?lang=en
   Trade Stats - Country Summary
 */

if (!isset($conn)) require_once("db_connection.php");

$sql = "CREATE TABLE TradesWith (
    countryCode VARCHAR(3),
    partnerCountryCode VARCHAR(20),
    type VARCHAR(6) NOT NULL,
    total VARCHAR(20) NOT NULL,
    PRIMARY KEY (countryCode, partnerCountryCode, type)
    )";

// use exec() because no results are returned
$conn->exec($sql);

$dir = new DirectoryIterator(dirname("../db_resources/wits_en_trade_summary/en_ABW_AllYears_WITS_Trade_Summary.CSV"));
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $countryCode = substr($fileinfo->getFilename(), 3, 3);

        if ($countryCode != "Wld") {
            $csvFile = file("../db_resources/wits_en_trade_summary/" . $fileinfo->getFilename());

            $data = [];
            foreach ($csvFile as $line) {
                //$data[] = str_getcsv($line);
                $contents = explode(",", $line);
                if ($contents[4] == "Trade (US$ Mil)-Top 5 Export Partner" || $contents[4] == "Trade (US$ Mil)-Top 5 Import Partner") {
                    $query = $conn->prepare("
                  SELECT countryCode
                  FROM Countries
                  WHERE name = :p_name
                ");

                    $query->bindValue(':p_name', utf8_encode($contents[1]), PDO::PARAM_STR);
                    $query->execute();
                    $p_code = $query->fetchAll(PDO::FETCH_ASSOC);

                    if ($p_code) {
                        $p_code = $p_code[0]['countryCode'];
                        $query = $conn->prepare("
                        INSERT INTO TradesWith (countryCode, partnerCountryCode, type, total)
                        VALUES (:code, :p_code, :type, :total)
                    ");

                        $query->bindValue(':code', $countryCode, PDO::PARAM_STR);
                        $query->bindValue(':p_code', $p_code, PDO::PARAM_STR);
                        $query->bindValue(':type', $contents[3], PDO::PARAM_STR);
                        $query->bindValue(':total', strval($contents[5]), PDO::PARAM_STR);
                        $query->execute();
                    }

                    /*
                    echo $p_code;
                    echo utf8_encode($contents[1]);
                    echo $contents[3];
                    echo strval($contents[5]);
                    */
                }
            }
        }

    }
}
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
$sql = "DROP TABLE if exists LanguagesSpoken";
$conn->exec($sql);

//2.create table LanguagesSpoken
$sql = "CREATE TABLE LanguagesSpoken (
    countryCode VARCHAR(3),
    language VARCHAR(100),
    percentPop VARCHAR(25),
    PRIMARY KEY (countryCode, language)
    )";

// use exec() because no results are returned
$conn->exec($sql);

$dir = new DirectoryIterator(dirname("../db_resources/geos/aa.html"));
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $factbookCode = substr($fileinfo->getFilename(), 0, 2);

        $html = file_get_html("../db_resources/geos/" . $fileinfo->getFilename());

        $query = $conn->prepare("
                      SELECT countryCode
                      FROM Countries
                      WHERE factbookCode = :f_code
                    ");

        $query->bindValue(':f_code', $factbookCode, PDO::PARAM_STR);
        $query->execute();
        $p_code = $query->fetchAll(PDO::FETCH_ASSOC);

        //echo $factbookCode . '<br>';
        //echo "-----------------<br>";

        if ($p_code && $factbookCode != "ay" && $factbookCode != "bv" && $factbookCode != "fs" && $factbookCode != "hm" && $factbookCode != "io") {
            $p_code = $p_code[0]['countryCode'];

            // Languages

            $langString = $html->find('h2[sectiontitle=People and Society]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->innertext;

            //echo $langString . "<br>";
            $allLangArr = explode(",", $langString);
            foreach ($allLangArr as $lang) {
                $theLang = "";
                if (strpos($lang, "(") !== false) {
                    $langArr = explode("(", $lang);
                    $theLang = $langArr[0];

                    if (strpos($theLang, "%") !== false) {
                        $lArr = explode(" ", $theLang);
                        if ($lArr[0]) {
                            $theLang = $lArr[0];
                            $percent = $lArr[1];
                        } else {
                            $theLang = $lArr[1];
                            $percent = $lArr[2];
                        }

                    } else {
                        $langArr = explode(")", $langArr[sizeof($langArr) - 1]);

                        $percent = "";
                        foreach ($langArr as $s) {
                            if (strpos($s, "%") !== false) {
                                $percent = $s;
                                break;
                            }
                        }
                    }
                } else {
                    $langArr = explode(" ", $lang);

                    $percent = "";
                    foreach ($langArr as $s) {
                        if (strpos($s, "%") !== false) {
                            $percent = $s;
                            break;
                        } else {
                            $theLang .= " " . $s;
                        }
                    }
                }

                //echo $theLang . " " . $percent . '<br>';

                $qstring = "INSERT IGNORE INTO LanguagesSpoken (countryCode, language";
                if (strlen($percent) > 1) $qstring .= ", percentPop";
                $qstring .= ") VALUES (:p_code, :lang";
                if (strlen($percent) > 1) $qstring .= ", :percent";
                $qstring .= ")";

                $theLang = trim($theLang);

                if (strpos($theLang, ")") === false && $theLang != "much bilingualism" && $theLang != "but Dari functions as the lingua franca" && $theLang != "official in Carinthia" && $theLang != "and Hungarian" && $theLang != "legally bilingual" && $theLang != "also" && $theLang != "official") {
                    $query = $conn->prepare($qstring);
                    $query->bindValue(':p_code', $p_code, PDO::PARAM_STR);
                    $query->bindValue(':lang', $theLang, PDO::PARAM_STR);
                    if (strlen($percent) > 1) $query->bindValue(':percent', $percent, PDO::PARAM_STR);
                    $query->execute();
                }
            }
        }
    }
}

<?php
/**
 * Created by IntelliJ IDEA.
 * User: T-Drive
 * Date: 3/5/16
 * Time: 3:19 PM
 */

if (!isset($conn)) require_once("db_connection.php");
include('simple_html_dom.php');

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

        if ($p_code) {
            $p_code = $p_code[0]['countryCode'];

            if ($factbookCode != "as" && $factbookCode != "at" && $factbookCode != "ax" && $factbookCode != "ay" && $factbookCode != "bd" && $factbookCode != "bq" && $factbookCode != "bv" && $factbookCode != "cr" && $factbookCode != "cw" && $factbookCode != "dq" && $factbookCode != "fr" && $factbookCode != "gz" && $factbookCode != "dx" && $factbookCode != "fs" && $factbookCode != "hk" && $factbookCode != "hm" && $factbookCode != "hq" && $factbookCode != "io" && $factbookCode != "ip" && $factbookCode != "jn" && $factbookCode != "jq" && $factbookCode != "kq" && $factbookCode != "lq" && $factbookCode != "mc" && $factbookCode != "mq" && $factbookCode != "nl" && $factbookCode != "no" && $factbookCode != "nz" && $factbookCode != "pf" && $factbookCode != "pg" && $factbookCode != "rn" && $factbookCode != "sv" && $factbookCode != "sx" && $factbookCode != "tb" && $factbookCode != "ts" && $factbookCode != "tw" && $factbookCode != "uk" && $factbookCode != "um" && $factbookCode != "us" && $factbookCode != "we" && $factbookCode != "wq") {
                // Chief of State
                $chief = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->children(0)->innertext;
                // Head of Gov
                $head = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->next_sibling()->children(0)->innertext;
            } elseif ($factbookCode == "ts") {
                // Chief of State
                $chief = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->next_sibling()->children(0)->innertext;
                // Head of Gov
                $head = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->next_sibling()->next_sibling()->children(0)->innertext;
            } elseif ($factbookCode == "as" || $factbookCode == "bd" || $factbookCode == "cw" || $factbookCode == "fr" || $factbookCode == "nl" || $factbookCode == "no" || $factbookCode == "nz" || $factbookCode == "uk" || $factbookCode == "us") { //34
                // Chief of State
                $chief = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->children(0)->innertext;
                // Head of Gov
                $head = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->next_sibling()->children(0)->innertext;
            } elseif ($factbookCode == "ax" || $factbookCode == "dx") { //16
                // Chief of State
                $chief = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->children(0)->innertext;
                // Head of Gov
                $head = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->next_sibling()->children(0)->innertext;
            } elseif ($factbookCode == "fs") { //13
                // Chief of State
                $chief = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->children(0)->innertext;
            } elseif ($factbookCode == "hk" || $factbookCode == "mc" || $factbookCode == "tw") { //28
                // Chief of State
                $chief = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->children(0)->innertext;
                // Head of Gov
                $head = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->next_sibling()->children(0)->innertext;
            } elseif ($factbookCode == "io") { //10
                // Chief of State
                $chief = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->children(0)->innertext;
                // Head of Gov
                $head = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->next_sibling()->children(0)->innertext;
            } elseif ($factbookCode == "rn" || $factbookCode == "tb") { //25
                // Chief of State
                $chief = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->children(0)->innertext;
                // Head of Gov
                $head = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->next_sibling()->children(0)->innertext;
            } elseif ($factbookCode == "sv") { //19
                // Chief of State
                $chief = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->children(0)->innertext;
                // Head of Gov
                $head = $html->find('h2[sectiontitle=Government]', 0)->next_sibling()->children(0)->children(0)->children(0)->children(0)->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->next_sibling()->children(0)->children(0)->next_sibling()->children(0)->innertext;
            }

            if ($chief) {
                $chiefArr = explode("; ", $chief);
                $chiefStartArr = explode("(since ", $chiefArr[0]);
                $chiefName = $chiefStartArr[0];
                $chiefStartArr = explode(")", $chiefStartArr[1]);
                $chiefStart = $chiefStartArr[0];

                $query = $conn->prepare("
                    INSERT IGNORE INTO Leaders (name, termStart, termEnd, type)
                    VALUES (:name, :t_start, 'Present', 'Chief of State')
                ");

                $query->bindValue(':name', $chiefName, PDO::PARAM_STR);
                $query->bindValue(':t_start', $chiefStart, PDO::PARAM_STR);
                $query->execute();

                $query = $conn->prepare("
                    INSERT IGNORE INTO LeaderOf (countryCode, leaderName)
                    VALUES (:c_code, :l_name)
                ");

                $query->bindValue(':c_code', $p_code, PDO::PARAM_STR);
                $query->bindValue(':l_name', $chiefName, PDO::PARAM_STR);
                $query->execute();
            }

            $headArr = explode("; ", $head);
            $headStartArr = explode("(since ", $headArr[0]);
            $headName = $headStartArr[0];
            $headStartArr = explode(")", $headStartArr[1]);
            $headStart = $headStartArr[0];

            if ($headName != "(vacant)") {
                $query = $conn->prepare("
                    INSERT IGNORE INTO Leaders (name, termStart, termEnd, type)
                    VALUES (:name, :t_start, 'Present', 'Head of Government')
                ");

                $query->bindValue(':name', $headName, PDO::PARAM_STR);
                $query->bindValue(':t_start', $headStart, PDO::PARAM_STR);
                $query->execute();

                $query = $conn->prepare("
                        INSERT IGNORE INTO LeaderOf (countryCode, leaderName)
                        VALUES (:c_code, :l_name)
                    ");

                $query->bindValue(':c_code', $p_code, PDO::PARAM_STR);
                $query->bindValue(':l_name', $headName, PDO::PARAM_STR);
                $query->execute();
            }
        }
    }
}
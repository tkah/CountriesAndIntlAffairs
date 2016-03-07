SHOW DATABASES;
USE countriesAndIntlAffairs;

DROP TABLE Migrations;

CREATE TABLE Migrations (
  destCountry VARCHAR(3), 
  origCountry VARCHAR(3),
  inYear      VARCHAR(4), 
  totalAmount DECIMAL(8)  NOT NULL,
  PRIMARY KEY(destCountry,origCountry,inYear));

LOAD DATA INFILE '/var/tmp/mig.csv'
INTO TABLE Migrations
COLUMNS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '"'
LINES TERMINATED BY '\n';

SELECT * FROM Migrations LIMIT 10;




drop database if exists countriesAndIntlAffairs;
CREATE DATABASE countriesAndIntlAffairs;
use countriesAndIntlAffairs;

drop table if exists Countries;
CREATE TABLE Countries (
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
    UNIQUE KEY(countryNumber));

drop table if exists Regions;    
CREATE TABLE Regions (
    subRegion VARCHAR(100) PRIMARY KEY,
    region VARCHAR(100) NOT NULL,
    UNIQUE KEY(subRegion));    

drop table if exists Borders;
CREATE TABLE Borders (
    countryCode VARCHAR(3),
    borderingCountryCode VARCHAR(3),
    PRIMARY KEY (countryCode, borderingCountryCode));    

drop table if exists Conflicts;    
CREATE TABLE Conflicts (
    conflictId VARCHAR(10) PRIMARY KEY,
    location VARCHAR(50),
    start VARCHAR(10),
    end VARCHAR(10));    

drop table if exists ConflictParties;
CREATE TABLE ConflictParties (
    conflictId VARCHAR(10),
    partyName VARCHAR(100),
    side VARCHAR(1),
    PRIMARY KEY (conflictId, partyName));

drop table if exists LanguagesSpoken;    
CREATE TABLE LanguagesSpoken (
    countryCode VARCHAR(3),
    language VARCHAR(100),
    percentPop VARCHAR(25),
    PRIMARY KEY (countryCode, language));

drop table if exists Leaders;
CREATE TABLE Leaders (
    name VARCHAR(150),
    type VARCHAR(25),
    termStart VARCHAR(30),
    termEnd VARCHAR(30),
    PRIMARY KEY (name, type));

drop table if exists LeaderOf;    
CREATE TABLE LeaderOf (
    countryCode VARCHAR(3),
    leaderName VARCHAR(150),
    PRIMARY KEY (countryCode, leaderName));

DROP table if exists Migrations;
CREATE TABLE Migrations (
  destCountry VARCHAR(3), 
  origCountry VARCHAR(3),
  inYear      VARCHAR(4), 
  totalAmount DECIMAL(8)  NOT NULL,
  PRIMARY KEY(destCountry,origCountry,inYear));

DROP table if exists  TradesWith;
CREATE TABLE TradesWith (
    countryCode VARCHAR(3),
    partnerCountryCode VARCHAR(20),
    type VARCHAR(6) NOT NULL,
    total VARCHAR(20) NOT NULL,
    PRIMARY KEY (countryCode, partnerCountryCode, type));

   
DROP table if exists Treaties;
CREATE TABLE Treaties(
  treatyNumber varchar(8),
  name  varchar(255)  NOT NULL,
  dateEnforced  varchar(8) NOT NULL,
  description varchar(255) NOT NULL,
  wikipage  varchar(255) NOT NULL,
  PRIMARY KEY(treatyNumber));    

DROP table if exists TreatyParties;
CREATE TABLE TreatyParties(
  treatyNumber varchar(8) NOT NULL,
  countryNumber  varchar(3)  NOT NULL,
  PRIMARY KEY(treatyNumber,countryNumber));

drop table if exists WorldBankStats;  
CREATE TABLE WorldBankStats (
    countryCode VARCHAR(3),
    statType VARCHAR(30),
    year VARCHAR(4),
    amount FLOAT(13,2),
    PRIMARY KEY (countryCode, statType, year));

USE countriesAndIntlAffairs;
#1) All countries by name (GENERAL, ORDER BY)
SELECT name 
FROM Countries 
ORDER BY name ASC;

#2) All countries where English is spoken (GENERAL, ORDER BY)
SELECT c.name 
FROM Countries c 
INNER JOIN LanguagesSpoken l ON l.countryCode = c.countryCode 
AND l.language = 'English' 
ORDER BY c.name ASC;

#3) All countries that border China
SELECT substr(C.name,1,20) AS BordersChina
FROM Borders B,Countries C  
WHERE B.countryCode = 'CHN'
AND B.borderingCountryCode = C.countryCode;

#4) Total Countries Involved in Each Conflict (3-WAY JOIN, GROUP BY) [ConflictParties filtered to just countries by JOIN]
SELECT con.conflictId, COUNT(c.countryCode) AS TotalCountryParties
FROM Countries c
INNER JOIN ConflictParties conP ON conP.partyName = c.countryCode
INNER JOIN Conflicts con ON con.conflictId = conP.conflictId
GROUP BY con.conflictId;

#5) Migrations with CountryCode instead of CountryNumber (3-WAY JOIN, use Countries twice)
SELECT A.countryCode destCode,B.countryCode origCode,M.inYear, M.totalAmount
FROM Migrations M
INNER JOIN Countries A ON M.destCountry = A.countryNumber
INNER JOIN Countries B ON M.origCountry = B.countryNumber
ORDER BY M.inYear;

#6) UNION of the Countries participated in both Biological and Chemical Weapons Conventions.
(SELECT substr(C.name,1,20) as countryName
FROM TreatyParties TP
INNER JOIN Treaties T ON TP.treatyNumber = T.treatyNumber
INNER JOIN Countries C ON TP.countryNumber = C.countryNumber
WHERE T.name like 'Bi%') UNION
(SELECT substr(C.name,1,20) as countryName
FROM TreatyParties TP
INNER JOIN Treaties T ON TP.treatyNumber = T.treatyNumber
INNER JOIN Countries C ON TP.countryNumber = C.countryNumber
WHERE T.name like 'Ch%');

#7) Number of countries within each region (GROUP BY, AGGREGATE)
SELECT r.region, COUNT(countryCode) AS TotalCountries 
FROM Countries c 
INNER JOIN Regions r ON r.subRegion = c.subregion 
GROUP BY r.region;

#8) Countries with Leaders (3-WAY JOIN, ORDER BY)
SELECT substr(c.name,1,20) AS CountryName, substr(l.name,1,25) AS LeaderName, substr(l.type,1,20) 
FROM Countries c 
INNER JOIN LeaderOf lo ON lo.countryCode = c.countryCode 
INNER JOIN Leaders l ON l.name = lo.leaderName 
ORDER BY c.name ASC;

#9) Trade between Regions (DISTINCT region pairs)
SELECT DISTINCT R1.region, R2.region, T.type, SUM(T.total)
FROM TradesWith T
INNER JOIN Countries C1 ON T.countryCode = C1.countryCode
INNER JOIN Countries C2 ON T.partnerCountryCode = C2.countryCode
INNER JOIN Regions R1 ON C1.subregion = R1.subRegion
INNER JOIN Regions R2 ON C2.subregion = R2.subRegion
WHERE R1.region < R2.region
GROUP BY R1.region, R2.region, type;

#10) Country/Year with greatest population (AGGREGATE)
SELECT substr(name,1,20) as countryName 
FROM Countries c 
INNER JOIN WorldBankStats wbs ON wbs.countryCode = c.countryCode 
WHERE wbs.statType = 'population'
AND wbs.amount = (SELECT MAX(amount) FROM WorldBankStats WHERE statType = 'population');






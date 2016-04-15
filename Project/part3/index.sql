USE countriesAndIntlAffairs;
SET profiling=1;
#=====================================
# compare index sppedup on Migrations
#=====================================
CREATE INDEX IDX_MIG_YEAR ON Migrations(inYear);
SELECT A.countryCode destCode,B.countryCode origCode,M.inYear, M.totalAmount
FROM Migrations M
INNER JOIN Countries A ON M.destCountry = A.countryNumber
INNER JOIN Countries B ON M.origCountry = B.countryNumber
ORDER BY M.inYear;

DROP INDEX IDX_MIG_YEAR ON Migrations;
SELECT A.countryCode destCode,B.countryCode origCode,M.inYear, M.totalAmount
FROM Migrations M
INNER JOIN Countries A ON M.destCountry = A.countryNumber
INNER JOIN Countries B ON M.origCountry = B.countryNumber
ORDER BY M.inYear;

#SHOW PROFILES;

#=========================================
# compare index sppedup on WorldBankStats
#=========================================
CREATE INDEX IDX_WBS_AMT ON WorldBankStats(amount);
SELECT substr(name,1,20) as countryName 
FROM Countries c 
INNER JOIN WorldBankStats wbs ON wbs.countryCode = c.countryCode 
WHERE wbs.statType = 'population'
AND wbs.amount = (SELECT MAX(amount) FROM WorldBankStats WHERE statType = 'population');

DROP INDEX IDX_WBS_AMT ON WorldBankStats;
SELECT substr(name,1,20) as countryName 
FROM Countries c 
INNER JOIN WorldBankStats wbs ON wbs.countryCode = c.countryCode 
WHERE wbs.statType = 'population'
AND wbs.amount = (SELECT MAX(amount) FROM WorldBankStats WHERE statType = 'population');

#SHOW PROFILES;

#=========================================
# compare index sppedup on TradesWith
#=========================================
CREATE INDEX IDX_TRW_TTL ON TradesWith(total);
SELECT DISTINCT R1.region, R2.region, T.type, SUM(T.total)
FROM TradesWith T
INNER JOIN Countries C1 ON T.countryCode = C1.countryCode
INNER JOIN Countries C2 ON T.partnerCountryCode = C2.countryCode
INNER JOIN Regions R1 ON C1.subregion = R1.subRegion
INNER JOIN Regions R2 ON C2.subregion = R2.subRegion
WHERE R1.region < R2.region
GROUP BY R1.region, R2.region, type;

DROP INDEX IDX_TRW_TTL ON TradesWith;
SELECT DISTINCT R1.region, R2.region, T.type, SUM(T.total)
FROM TradesWith T
INNER JOIN Countries C1 ON T.countryCode = C1.countryCode
INNER JOIN Countries C2 ON T.partnerCountryCode = C2.countryCode
INNER JOIN Regions R1 ON C1.subregion = R1.subRegion
INNER JOIN Regions R2 ON C2.subregion = R2.subRegion
WHERE R1.region < R2.region
GROUP BY R1.region, R2.region, type;

SHOW PROFILES;

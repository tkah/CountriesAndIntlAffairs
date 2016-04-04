USE countriesAndIntlAffairs;
#1) update TradesWith set minimum total to 0.0
UPDATE TradesWith
SET total='0.0'
WHERE total='';

#2) update WorldBankStats set population = population + 1
UPDATE WorldBankStats
SET amount = amount + 1
WHERE statType='population';

#3) insert a Leader
INSERT INTO Leaders(name,type,termStart,termEnd)
VALUES('Yuan Shikai','Emperor of Empire of China','22 December 1915','22 March 1916');

#4) insert a LeaderOf
INSERT INTO LeaderOf(countryCode,leaderName)
VALUES('CHN','Yuan Shikai');

#5) delete a Leader
DELETE FROM Leaders
WHERE name = 'Yuan Shikai';

#6) delete a LeaderOf
DELETE FROM LeaderOf
WHERE leaderName = 'Yuan Shikai';










DROP TABLE IF EXIST Treaties;
CREATE TABLE Treaties(
  treatyNumber varchar(8),
  name  varchar(255)  NOT NULL,
  dateEnforced  varchar(8) NOT NULL,
  description varchar(255) NOT NULL,
  wikipage  varchar(255) NOT NULL,
  PRIMARY KEY(treatyNumber)
);

INSERT INTO Treaties VALUES
('UNI35597','Ottawa Treaty','19990301','Prohibition of the Use, Stockpiling, Production and Transfer of Anti-Personnel Mines and on their Destruction','https://en.wikipedia.org/wiki/List_of_parties_to_the_Ottawa_Treaty');

INSERT INTO Treaties VALUES
('UNI38544','Rome Statute','20020701','Rome Statute of the International Criminal Court','https://en.wikipedia.org/wiki/States_parties_to_the_Rome_Statute_of_the_International_Criminal_Court');

INSERT INTO Treaties VALUES
('UNI20378','Elimination of Discrimination against Women','19810903','Convention on the Elimination of All Forms of Discrimination against Women','https://en.wikipedia.org/wiki/List_of_parties_to_the_Convention_on_the_Elimination_of_All_Forms_of_Discrimination_Against_Women');

INSERT INTO Treaties VALUES
('UNI30822','Framework Convention on Climate Change','19940321','United Nations Framework Convention on Climate Change','https://en.wikipedia.org/wiki/List_of_parties_to_the_United_Nations_Framework_Convention_on_Climate_Change');

INSERT INTO Treaties VALUES
('UNA30822','Kyoto Protocol','20050216','Kyoto Protocol to the United Nations Framework Convention on Climate Change','https://en.wikipedia.org/wiki/List_of_parties_to_the_Kyoto_Protocol');

INSERT INTO Treaties VALUES
('UNI01021','Genocide Convention','19510112','Prevention and Punishment of the Crime of Genocide (CPPCG)','https://en.wikipedia.org/wiki/Genocide_Convention');

INSERT INTO Treaties VALUES
('UNI31363','Law of the Sea','19941116','United Nations Convention on the Law of the Sea','https://en.wikipedia.org/wiki/List_of_parties_to_the_United_Nations_Convention_on_the_Law_of_the_Sea');

INSERT INTO Treaties VALUES
('UNI14860','Biological Weapons Convention','19750326','Convention on the prohibition of the development, production and stockpiling of bacteriological (biological) and toxin weapons and on their destruction','https://en.wikipedia.org/wiki/List_of_parties_to_the_Biological_Weapons_Convention');

INSERT INTO Treaties VALUES
('UNI33757','Chemical Weapons Convention','19970429','Convention on the Prohibition of the Development, Production, Stockpiling and Use of Chemical Weapons and on their Destruction','https://en.wikipedia.org/wiki/List_of_parties_to_the_Chemical_Weapons_Convention');

INSERT INTO Treaties VALUES
('UNI10485','Non-Proliferation of Nuclear Weapons','19700305','Treaty on the Non-Proliferation of Nuclear Weapons','https://en.wikipedia.org/wiki/List_of_parties_to_the_Treaty_on_the_Non-Proliferation_of_Nuclear_Weapons');

INSERT INTO Treaties VALUES
('ICRC0001','Geneva Conventions','19490812','The Geneva Conventions comprise four treaties, and three additional protocols, that establish the standards of international law for the humanitarian treatment of war','https://en.wikipedia.org/wiki/Geneva_Conventions');

DROP TABLE IF EXIST TreatyParties;
CREATE TABLE TreatyParties(
  treatyNumber varchar(8) NOT NULL,
  countryNumber  varchar(3)  NOT NULL,
  PRIMARY KEY(treatyNumber,countryNumber)
);

LOAD DATA INFILE '/var/tmp/outTreaty.csv'
INTO TABLE TreatyParties
COLUMNS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '"'
LINES TERMINATED BY '\n';

SELECT * FROM TreatyParties LIMIT 10;

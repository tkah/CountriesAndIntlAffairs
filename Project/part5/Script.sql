USE countriesAndIntlAffairs;
-- create function
DROP FUNCTION if exists median_udf;
CREATE AGGREGATE FUNCTION median_udf
RETURNS INTEGER SONAME "median_udf.so";
-- create a test table t
DROP TABLE if exists t;
CREATE TABLE t (
    a int PRIMARY KEY,
    b int NOT NULL
);
INSERT INTO t VALUES
(10,1),(20,1),(30,1),
(50,2),(12,2),(22,2),(60,2),(100,2);
-- test function on table t
SELECT a,b 
FROM t
ORDER BY b,a;
SELECT median_udf(a)
FROM t
GROUP BY b;
-- test function on table Migrations
SELECT median_udf(totalAmount),origCountry,inYear
FROM Migrations
WHERE destCountry='840'
group by inYear;
 

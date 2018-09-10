/* a */
SELECT
	HOUR(DateTime) as hour,
	SUM(Throughput) as trips
FROM rides2017
GROUP BY hour;


/* b */
SELECT
	Origin
	Destination
FROM rides2017
WHERE DAYOFWEEK(DateTime) < 5
GROUP BY Origin, Destination
ORDER BY SUM(Throughput)
LIMIT 1;


/* c */
SELECT
	Destination
FROM rides2017
WHERE (DAYOFWEEK(DateTime) = 0)
	AND (HOUR(DateTime) >= 7 AND HOUR(DateTime) < 10)
GROUP BY Destination
ORDER BY SUM(Throughput)
LIMIT 5;


/* d */
SELECT
	Origin
FROM (
	SELECT
		Origin
		SUM(Throughput) as Throughput
		DateTime
	FROM rides2017
	GROUP BY Origin DateTime
) origins
WHERE MAX(Throughput) > (100 * AVG(Throughput))
GROUP BY Origin;

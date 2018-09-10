-- a)
SELECT 
	highway,
	area
FROM caltrans
WHERE text like '%IS CLOSED%' and (text like '%DUE TO SNOW%' or text like '%FOR THE WINTER%')
GROUP BY highway, area
ORDER BY highway DESC, area DESC
LIMIT 20;

+---------+-------------------------------------------------+
| highway | area                                            |
+---------+-------------------------------------------------+
| US395   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |
| SR89    | IN THE NORTHERN CALIFORNIA AREA & SIERRA NEVADA |
| SR89    | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |
| SR88    | IN THE CENTRAL CALIFORNIA & SIERRA NEVADA       |
| SR4     | IN THE CENTRAL CALIFORNIA AREA                  |
| SR38    | IN THE SOUTHERN CALIFORNIA AREA                 |
| SR330   | IN THE SOUTHERN CALIFORNIA AREA                 |
| SR33    | IN THE SOUTHERN CALIFORNIA AREA                 |
| SR3     | IN THE NORTHERN CALIFORNIA AREA                 |
| SR270   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |
| SR267   | IN THE NORTHERN CALIFORNIA AREA                 |
| SR203   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |
| SR20    | IN THE NORTHERN CALIFORNIA AREA                 |
| SR2     | IN THE SOUTHERN CALIFORNIA AREA                 |
| SR18    | IN THE SOUTHERN CALIFORNIA AREA                 |
| SR172   | IN THE NORTHERN CALIFORNIA AREA                 |
| SR168   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |
| SR158   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |
| SR138   | IN THE SOUTHERN CALIFORNIA AREA                 |
| SR130   | IN THE CENTRAL CALIFORNIA AREA                  |
+---------+-------------------------------------------------+
20 rows in set (0.06 sec)


-- b)
-- Method 1: subquery
SELECT 
	highway,
	area,
	100*COUNT(*)/365 as percentage
FROM (
	SELECT 
		highway,area,DATE(reported)
	FROM caltrans
	WHERE text like '%IS CLOSED%' and (text like '%DUE TO SNOW%' or text like '%FOR THE WINTER%')
	GROUP BY highway, area, DATE(reported)
) closed
GROUP BY highway, area
ORDER BY 100*COUNT(*)/365 DESC
LIMIT 5;

+---------+-------------------------------------------------+------------+
| highway | area                                            | percentage |
+---------+-------------------------------------------------+------------+
| SR89    | IN THE NORTHERN CALIFORNIA AREA & SIERRA NEVADA |    66.3014 |
| SR120   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |    61.6438 |
| SR203   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |    61.3699 |
| SR108   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |    55.6164 |
| SR4     | IN THE CENTRAL CALIFORNIA AREA                  |    54.7945 |
+---------+-------------------------------------------------+------------+
5 rows in set (0.07 sec)

-- Method 2: inner join
SELECT 
	caltrans.highway,
	caltrans.area,
	100*COUNT(DISTINCT DATE(caltrans.reported))/365 as percentage
FROM 
caltrans INNER JOIN
(
	SELECT 
		highway,area
	FROM caltrans
	WHERE text like '%IS CLOSED%' AND (text like '%DUE TO SNOW%' or text like '%FOR THE WINTER%')
	GROUP BY highway, area
) sub 
ON caltrans.highway = sub.highway AND caltrans.area = sub.area
WHERE text like '%IS CLOSED%' AND (text like '%DUE TO SNOW%' or text like '%FOR THE WINTER%')
GROUP BY caltrans.highway, caltrans.area
ORDER BY 100*COUNT(DISTINCT DATE(caltrans.reported))/365 DESC
LIMIT 5;

+---------+-------------------------------------------------+------------+
| highway | area                                            | percentage |
+---------+-------------------------------------------------+------------+
| SR89    | IN THE NORTHERN CALIFORNIA AREA & SIERRA NEVADA |    66.3014 |
| SR120   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |    61.6438 |
| SR203   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |    61.3699 |
| SR108   | IN THE CENTRAL CALIFORNIA AREA & SIERRA NEVADA  |    55.6164 |
| SR4     | IN THE CENTRAL CALIFORNIA AREA                  |    54.7945 |
+---------+-------------------------------------------------+------------+
5 rows in set (0.15 sec)

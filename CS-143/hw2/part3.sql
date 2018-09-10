-- a)
SELECT
	trip_starts.trip_id, trip_starts.user_id, ifnull(TIMESTAMPDIFF(second, trip_starts.time, trip_ends.time), 86400) as elapsed
FROM trip_starts LEFT JOIN trip_ends
ON trip_starts.trip_id = trip_ends.trip_id and trip_starts.user_id = trip_ends.user_id
LIMIT 5;

+---------+---------+---------+
| trip_id | user_id | elapsed |
+---------+---------+---------+
|       0 |   20685 |      72 |
|       2 |   34808 |     179 |
|       3 |   25463 |   86400 |
|       4 |   26965 |      94 |
|       5 |     836 |      51 |
+---------+---------+---------+
5 rows in set (0.00 sec)

-- b)
SELECT
	trip_starts.trip_id, trip_starts.user_id, 1 + 0.15 * CEIL(ifnull(TIMESTAMPDIFF(second, trip_starts.time, trip_ends.time), 86400)/60) as price
FROM trip_starts LEFT JOIN trip_ends
ON trip_starts.trip_id = trip_ends.trip_id and trip_starts.user_id = trip_ends.user_id
LIMIT 5;
+---------+---------+--------+
| trip_id | user_id | price  |
+---------+---------+--------+
|       0 |   20685 |   1.30 |
|       2 |   34808 |   1.45 |
|       3 |   25463 | 217.00 |
|       4 |   26965 |   1.30 |
|       5 |     836 |   1.15 |
+---------+---------+--------+
5 rows in set (0.00 sec)

-- c)
SELECT
	user_id, SUM(price) as monthly_price
FROM(
	SELECT
		trip_starts.trip_id, trip_starts.user_id, trip_starts.time, LEAST(100.00, SUM(1 + 0.15 * CEIL(ifnull(TIMESTAMPDIFF(second, trip_starts.time, trip_ends.time), 86400)/60))) as price
	FROM trip_starts LEFT JOIN trip_ends
	ON trip_starts.trip_id = trip_ends.trip_id and trip_starts.user_id = trip_ends.user_id
	WHERE MONTH(DATE(trip_starts.time)) = 3
	GROUP BY trip_starts.user_id, trip_starts.trip_id
)subquery
WHERE MONTH(DATE(time)) = 3
GROUP BY user_id
LIMIT 5;

+---------+---------------+
| user_id | monthly_price |
+---------+---------------+
|       0 |        105.50 |
|       1 |          4.05 |
|       2 |        314.05 |
|       3 |         11.90 |
|       4 |        210.55 |
+---------+---------------+
5 rows in set (2.44 sec)

In particular, user id = 2 owes $314.05.

-- d)
Self-Left-Equi-Join
(trip_starts on the left side)


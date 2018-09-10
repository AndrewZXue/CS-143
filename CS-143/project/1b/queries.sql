SELECT
	CONCAT(first, ' ', last) AS Name
FROM (
	SELECT
		aid
	FROM MovieActor
	INNER JOIN Movie ON
		MovieActor.mid = Movie.id
	WHERE
		title = 'Die Another Day'
) ActorID
INNER JOIN Actor ON
	ActorID.aid = Actor.id;



SELECT
	COUNT(aid) AS Count
FROM (
	SELECT
		aid,
		COUNT(aid) AS num
	FROM MovieActor
	GROUP BY aid
) Actor_Num
WHERE
	num > 1;



SELECT
	Count(Director.id)
FROM Actor
INNER JOIN Director
ON
	Actor.ID = Director.ID;
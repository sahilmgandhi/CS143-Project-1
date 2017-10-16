
-- Names of all the actors in the movie 'Death to Smoochy'
SELECT CONCAT(a.first, ' ', a.last)
FROM MovieActor AS ma, Movie AS m, Actor AS a
WHERE m.title='Death to Smoochy'
AND ma.aid = a.id
AND ma.mid = m.id;

-- Find the number of directors who have directed at least 4 movies.
SELECT COUNT(*) FROM(
	SELECT COUNT(*)
	FROM MovieDirector AS md
	GROUP BY md.did
	HAVING (COUNT(md.did) >= 4)
) AS temp;

-- Custom query # 1: Total tickets sold and income of all movies starring Hugh Jackman
SELECT SUM(s.ticketsSold), SUM(s.totalIncome)
FROM Actor AS a, MovieActor AS ma, Sales AS s
WHERE a.first='Hugh' AND a.last='Jackman' AND a.id = ma.aid AND ma.mid = s.mid;

-- Custom query #2: Find director that has worked with the most actors
SELECT CONCAT(d.first, ' ', d.last)
FROM MovieActor AS ma
JOIN MovieDirector AS md
    ON ma.mid = md.mid
JOIN Director AS d
    ON md.did = d.id
GROUP BY ma.aid
ORDER BY COUNT(ma.aid) DESC
LIMIT 1;

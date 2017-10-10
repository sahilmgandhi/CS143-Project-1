
-- Names of all the actors in the movie 'Death to Smoochy'
SELECT CONCAT(a.last, ' ', a.first)
FROM MovieActor AS ma, Movie AS m, Actor AS a
WHERE m.title='Death to Smoochy'
AND ma.aid = a.id
AND ma.mid = m.id;

-- Find the number of directors who have directed at least 4 movies.
SELECT COUNT(DISTINCT d.id)
FROM Director AS d, MovieDirector AS md
WHERE d.id = md.did
HAVING (COUNT(d.id) >= 4);

-- Custom query # 1: Total tickets sold and  Income of all movies starring Hugh Jackman
SELECT SUM(s.ticketsSold), SUM(s.totalIncome)
FROM Actor AS a, MovieActor AS ma, Sales AS s
WHERE a.first='Hugh' AND a.last='Jackman' AND a.id = ma.aid AND ma.mid = s.mid;

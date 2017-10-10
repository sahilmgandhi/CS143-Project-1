
-- Names of all the actors in the movie 'Death to Smoochy'
SELECT CONCAT(a.last, ' ', a.first)
FROM MovieActor AS ma, Movie AS m, Actor AS a
WHERE m.title='Death to Smoochy'
AND ma.aid = a.id
AND ma.mid = m.id;

-- Find the number of directors who have directed atleast 4 movies.
SELECT COUNT(DISTINCT d.id)
FROM Director AS d, MovieDirector AS md
WHERE d.id = md.did
HAVING (COUNT(d.id) >= 4);

-- Names of all the actors in the movie 'Death to Smoochy'
SELECT CONCAT(a.last, ' ', a.first)
FROM MovieActor AS ma, Movie AS m, Actor AS a
WHERE m.title='Death to Smoochy'
AND ma.aid = a.id
AND ma.mid = m.id
ORDER BY a.last;


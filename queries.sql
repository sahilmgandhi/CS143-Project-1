SELECT CONCAT(a.last, ' ', a.first)
FROM MovieActor AS ma
JOIN Movie AS m
ON ma.mid = m.id
JOIN Actor AS a
ON ma.aid = a.id
WHERE m.title='Death to Smoochy'
ORDER BY a.last;
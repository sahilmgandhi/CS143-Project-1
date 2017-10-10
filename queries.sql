
-- Find the number of directors who have directed atleast 4 movies.
SELECT COUNT(DISTINCT d.id)
FROM Director AS d, MovieDirector AS md
WHERE d.id = md.did
HAVING (COUNT(d.id) >= 4);

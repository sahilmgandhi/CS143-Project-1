-- Primary Key: Movie cannot have duplicate id
INSERT INTO Movie VALUES (2, "Title", 2000, "G", "Company");
-- ERROR 1062 (23000): Duplicate entry '2' for key 'PRIMARY'

-- Primary key: Actor cannot have duplicate id
INSERT INTO Actor VALUES (1, "Last", "First", "Male", "2015-05-05", NULL);
-- ERROR 1062 (23000): Duplicate entry '1' for key 'PRIMARY'

-- Primary key: Director cannot have duplicate id
INSERT INTO Director VALUES (16, "Last", "First", "2015-05-05", NULL);
-- ERROR 1062 (23000): Duplicate entry '16' for key 'PRIMARY'

-- Foreign key: Cannot have more than one entry per foreign key of movie id
INSERT INTO Sales VALUES (2, 12, 1200);
-- ERROR 1062 (23000): Duplicate entry '2' for key 'mid'

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Movie
INSERT INTO MovieGenre VALUES (131, "Comedy");
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Movie
INSERT INTO MovieDirector VALUES (131, 2);
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`) ON DELETE CASCADE UPDATE CASCADE)

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Director
INSERT INTO MovieDirector VALUES (2, 1358);
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Movie
INSERT INTO MovieActor VALUES (131, 1, "Role");
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Actor
INSERT INTO MovieActor VALUES (1, 173, "Role");
-- │ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)

-- Foreign key: Cannot have more than one entry per foreign key of movie id
INSERT INTO MovieRating VALUES (2, 20, 20);
-- ERROR 1062 (23000): Duplicate entry '2' for key 'mid'

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Movie
INSERT INTO Review VALUES ("Name", "2015-05-05 00:00:05", 131, 3, "Comment");
-- │ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)

-- The following are checks for which we cannot show the error code (since mysql doesnt support the check statement)

-- Check: Movie cannot be made before first movie
INSERT INTO Movie VALUES (1, "Title", 1700, "G", "Company");

-- Check: Actor birthday can't be in future
INSERT INTO Actor VALUES (2, "Last", "First", "Male", "2019-05-05", NULL);

-- Check: Director birthday can't be in future
INSERT INTO Director VALUES (2, "Last", "First", "2019-05-05", NULL);

-- Check: Actor can't die before birthday
INSERT INTO Actor VALUES (2, "Last", "First", "Male", "2015-05-05", "2014-04-04");

-- Check: Director can't die before birthday
INSERT INTO Director VALUES (2, "Last", "First", "2015-05-05", "2014-04-04");

-- Check: Movie imdb score has to be between 0 and 100
INSERT INTO MovieRating VALUES (2, 500, 50);

-- Check: Movie rot score has to be between 0 and 100
INSERT INTO MovieRating VALUES (2, 50, 500);

-- Check: Review has to be out of 5
INSERT INTO Review VALUES ("Name", "2015-05-05 00:00:05", 1, 6, "Comment");
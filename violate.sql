-- Primary Key: Movie cannot have duplicate id
INSERT INTO Movie VALUES (2, "Title", 2000, "G", "Company");

-- Primary key: Actor cannot have duplicate id
INSERT INTO Actor VALUES (1, "Last", "First", "Male", "2015-05-05", NULL);

-- Primary key: Director cannot have duplicate id
INSERT INTO Director VALUES (16, "Last", "First", "2015-05-05", NULL);

-- Foreign key: Cannot have more than one entry per foreign key of movie id
INSERT INTO Sales VALUES (2, 12, 1200);

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Movie
INSERT INTO MovieGenre VALUES (1, "Comedy");

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Movie
INSERT INTO MovieDirector VALUES (1, 2);

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Director
INSERT INTO MovieDirector VALUES (2, 2);

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Movie
INSERT INTO MovieActor VALUES (1, 1, "Role");

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Actor
INSERT INTO MovieActor VALUES (1, 2, "Role");

-- Foreign key: Cannot have more than one entry per foreign key of movie id
INSERT INTO MovieRating VALUES (2, 20, 20);

-- Foreign key: Cannot insert entry without a corresponding primary key entry in Movie
INSERT INTO Review VALUES ("Name", "2015-05-05 00:00:05", 1, 3, "Comment");

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
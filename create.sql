CREATE TABLE Movie(
	id int, title char(100), year int, rating char(10), company char(50)
);

CREATE TABLE Actor(
	id int, last char(20), first char(20), sex char(6), dob date, dod date
);

CREATE TABLE Sales(
	mid int, ticketsSold int, totalIncome int
);

CREATE TABLE Director(
	id int, last char(20), first char(20), dob date, dod date
);

CREATE TABLE MovieGenre(
	mid int, genre char(20)
);

CREATE TABLE MovieDirector(
	mid int, did int
);

CREATE TABLE MovieActor(
	mid int, aid int, role char(50)
);

CREATE TABLE MovieRating(
	mid int, imdb int, rot int
);

CREATE TABLE Review(
	name char(20), `time` time, mid int, rating int, comment text(500)
);

CREATE TABLE MaxPersonID(
	id int
);

INSERT INTO MaxPersonID VALUES(69000);

CREATE TABLE MaxMovieID(
	id int
);

INSERT INTO MaxMovieID VALUES(4750);

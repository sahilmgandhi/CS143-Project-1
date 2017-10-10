CREATE TABLE Movie(
	id int, title char(100), year int, rating char(10), company char(50), PRIMARY KEY(id, title)
);

CREATE TABLE Actor(
	id int, last char(20), first char(20), sex char(6), dob date, dod date, PRIMARY KEY(id, first, last)
);

CREATE TABLE Sales(
	mid int PRIMARY KEY, ticketsSold int, totalIncome int
);

CREATE TABLE Director(
	id int PRIMARY KEY, last char(20), first char(20), dob date, dod date
);

CREATE TABLE MovieGenre(
	mid int PRIMARY KEY, genre char(20)
);

CREATE TABLE MovieDirector(
	mid int, did int, PRIMARY KEY(mid, did)
);

CREATE TABLE MovieActor(
	mid int, aid int, role char(50), PRIMARY KEY(mid, aid)
);

CREATE TABLE MovieRating(
	mid int PRIMARY KEY, imdb int, rot int
);

CREATE TABLE Review(
	name char(20), `time` time, mid int, rating int, comment text(500), PRIMARY KEY(name, mid)
);

CREATE TABLE MaxPersonID(
	id int
);

CREATE TABLE MaxMovieID(
	id int
);

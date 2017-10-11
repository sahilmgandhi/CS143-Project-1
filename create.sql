CREATE TABLE Movie(
	id int NOT NULL,
	title char(100) NOT NULL,
	year int NOT NULL,
	rating char(10),
	company char(50),
	PRIMARY KEY(id),
	INDEX(title)
);

CREATE TABLE Actor(
	id int NOT NULL,
	last char(20),
	first char(20),
	sex char(6),
	dob date,
	dod date,
	PRIMARY KEY(id),
	INDEX(first, last)
);

CREATE TABLE Sales(
	mid int NOT NULL,
	ticketsSold int NOT NULL,
	totalIncome int NOT NULL,
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Director(
	id int NOT NULL,
	last char(20),
	first char(20),
	dob date,
	dod date,
	PRIMARY KEY(id),
	INDEX(first, last)
);

CREATE TABLE MovieGenre(
	mid int NOT NULL,
	genre char(20),
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE MovieDirector(
	mid int NOT NULL,
	did int NOT NULL, 
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(did) REFERENCES Director(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE MovieActor(
	mid int NOT NULL,
	aid int NOT NULL,
	role char(50),
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(aid) REFERENCES Actor(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE MovieRating(
	mid int NOT NULL,
	imdb int,
	rot int,
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Review(
	name char(20),
	`time` time,
	mid int NOT NULL,
	rating int,
	comment text(500),
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE MaxPersonID(
	id int NOT NULL
);

CREATE TABLE MaxMovieID(
	id int NOT NULL
);

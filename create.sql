CREATE TABLE Movie(
	id 		INT UNSIGNED NOT NULL, -- ID's should not be negative, and should exist
	title 	VARCHAR(100) NOT NULL, -- A movie has to have a title
	year 	INT UNSIGNED NOT NULL, -- A movie has to be released at some point
	rating 	VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY(id),	-- ID is a primary way to identify a movie
	INDEX(title),
	UNIQUE(id),			-- Each movie should have a unique ID
	CHECK(year > 1878) 	-- Year the first movie was made
) ENGINE = INNODB;

CREATE TABLE Actor(
	id 		INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	last 	VARCHAR(20),
	first 	VARCHAR(20),
	sex 	VARCHAR(6),
	dob 	DATE NOT NULL, 	-- Every person is born at some point
	dod 	DATE,
	PRIMARY KEY(id),		-- ID is a primary way to identify an actor
	INDEX(first, last),
	UNIQUE(id),				-- Each actor should have a unique ID
	CHECK(dob <= CURDATE())	-- Can't have people born in the future
) ENGINE = INNODB;

CREATE TABLE Sales(
	mid 		INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	ticketsSold	INT UNSIGNED NOT NULL,	-- If there's no sales, can just be 0
	totalIncome	INT UNSIGNED NOT NULL,	-- If there's no sales, can just be 0
	UNIQUE(mid), -- Each movie should have only 1 sales entry
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE -- The mid should correspond to some movie's ID. If the movie is deleted or updated, cascade the update/deletion
) ENGINE = INNODB;

CREATE TABLE Director(
	id 		INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	last 	VARCHAR(20),
	first 	VARCHAR(20),
	dob 	DATE NOT NULL, 	-- Every person has to be born at some point
	dod 	DATE,
	PRIMARY KEY(id),		-- ID is a primary way to identify a director
	INDEX(first, last),
	UNIQUE(id),				-- Each director should have a unique ID
	CHECK(dob <= CURDATE())	-- Can't have people born in the future
) ENGINE = INNODB;

CREATE TABLE MovieGenre(
	mid 	INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	genre 	VARCHAR(20) NOT NULL,	-- A movie has to have a genre, even if it's "Other"
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE -- The mid should correspond to some movie's ID. If the movie is deleted or updated, cascade the update/deletion
) ENGINE = INNODB;

CREATE TABLE MovieDirector(
	mid INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	did INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE, 		-- The mid should correspond to some movie's ID. If the movie is deleted or updated, cascade the update/deletion
	FOREIGN KEY(did) REFERENCES Director(id) ON DELETE CASCADE ON UPDATE CASCADE 	-- The did should correspond to some director's ID. If the director is deleted or updated, cascade the update/deletion
) ENGINE = INNODB;

CREATE TABLE MovieActor(
	mid 	INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	aid 	INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	role 	VARCHAR(50) NOT NULL,	-- You're not an actor in a movie if you don't have a role
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE, 	-- The mid should correspond to some movie's ID. If the movie is deleted or updated, cascade the update/deletion
	FOREIGN KEY(aid) REFERENCES Actor(id) ON DELETE CASCADE ON UPDATE CASCADE 	-- The aid should correspond to some actor's ID. If the actor is deleted or updated, cascade the update/deletion
) ENGINE = INNODB;

CREATE TABLE MovieRating(
	mid 	INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	imdb 	INT,
	rot 	INT,
	UNIQUE(mid), -- A movie shouldn't be able to have 2 rating definitions
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE -- The mid should correspond to some movie's ID. If the movie is deleted or updated, cascade the update/deletion
) ENGINE = INNODB;

CREATE TABLE Review(
	name 	VARCHAR(20),
	`time` 	TIMESTAMP, 				-- Quote the column name time since it is reserved in MySQL
	mid 	INT UNSIGNED NOT NULL,	-- ID's should not be negative, and should exist
	rating 	INT,
	comment VARCHAR(500),
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE -- The mid should correspond to some movie's ID. If the movie is deleted or updated, cascade the update/deletion
) ENGINE = INNODB;

CREATE TABLE MaxPersonID(
	id INT UNSIGNED NOT NULL -- ID's should not be negative, and should exist
) ENGINE = INNODB;

CREATE TABLE MaxMovieID(
	id INT UNSIGNED NOT NULL -- ID's should not be negative, and should exist
) ENGINE = INNODB;

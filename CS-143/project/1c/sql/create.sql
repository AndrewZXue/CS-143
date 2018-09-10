CREATE TABLE Movie (
	id			INT,
	title 		VARCHAR(100) NOT NULL,
	year		INT NOT NULL,
	rating		VARCHAR(10),
	company		VARCHAR(50),
	PRIMARY KEY (id),	
					-- id is unique for each movie
	CHECK(year > 0 AND year < 2019)
					-- year should be a valid time, not negative
) ENGINE = INNODB;

CREATE TABLE Actor (
	id			INT,
	last		VARCHAR(20) NOT NULL,
	first		VARCHAR(20) NOT NULL,
	sex			VARCHAR(6),
	dob			DATE NOT NULL,
	dod			DATE,
	PRIMARY KEY (id),
					-- id is unique for every actor
	CHECK(YEAR(dob) > 0 AND YEAR(dob) < 2019)
					-- date of birth should be a vaild time, not negative
) ENGINE = INNODB;

CREATE TABLE Director (
	id			INT,
	last		VARCHAR(20) NOT NULL,
	first		VARCHAR(20) NOT NULL,
	dob			DATE NOT NULL,
	dod			DATE,
	PRIMARY KEY (id),
					-- id is unique for every director
	CHECK(YEAR(dob) > 0 AND YEAR(dob) < 2019)
					-- date of birth should be a vaild time, not negative
) ENGINE = INNODB;

CREATE TABLE MovieGenre (
	mid 		INT,
	genre  		VARCHAR(20),
	FOREIGN KEY (mid) references Movie(id)
					-- mid is the primary key in Movie
) ENGINE = INNODB;

CREATE TABLE MovieDirector (
	mid 		INT,
	did			INT,
	FOREIGN KEY (mid) references Movie(id),
					-- mid is the primary key in Movie
	FOREIGN KEY (did) references Director(id)
					-- did is the primary key in Director
) ENGINE = INNODB;

CREATE TABLE MovieActor (
	mid 		INT,
	aid			INT,
	role		VARCHAR(50),
	FOREIGN KEY (mid) references Movie(id),
					-- mid is the primary key in Movie
	FOREIGN KEY (aid) references Actor(id)
					-- did is the primary key in Actor
) ENGINE = INNODB;

CREATE TABLE Review (
	name		VARCHAR(20),
	time		TIMESTAMP,
	mid  		INT,
	rating		INT,
	comment		VARCHAR(500),
	FOREIGN KEY (mid) references Movie(id)
					-- mid is the primary key in Movie
) ENGINE = INNODB;

CREATE TABLE MaxPersonID (
	id 			INT NOT NULL
) ENGINE = INNODB;

CREATE TABLE MaxMovieID (
	id 			INT NOT NULL
) ENGINE = INNODB;
























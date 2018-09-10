INSERT INTO Movie VALUES (6, 'Avengers', 2018, 'PG-13', 'Marvel');
	-- The id should be unique but 6 already exists in Movie table
	-- Result: ERROR 1062 (23000): Duplicate entry '6' for key 'PRIMARY'
INSERT INTO Actor VALUES (14, 'Bai', 'Jingting', 'Male', '1993-10-15', \N);
	-- The id should be unique but 14 already exists in Actor table
	-- ERROR 1062 (23000): Duplicate entry '14' for key 'PRIMARY'
INSERT INTO Director VALUES (16, 'Bai', 'Jingting', '1993-10-15', \N);
	-- The id should be unique but 16 already exists in Director table
	-- ERROR 1062 (23000): Duplicate entry '16' for key 'PRIMARY'
INSERT INTO MovieGenre VALUES (49000, 'Dramma');
	-- The id should be in Movie table but 49000 doesn't.
	-- Result: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO MovieDirector VALUES(49000, 16);
	-- The mid should be in Movie table but 49000 doesn't.
	-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO MovieDirector VALUES(6, 57000);
	-- The did should be in Director table but 57000 doesn't.
	-- Result: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))
INSERT INTO MovieActor VALUES(49000, 16, 'Grace');
	-- The mid should be in Movie table but 49000 doesn't.
	-- Result: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO MovieActor VALUES(6, 57000, 'Grace');
	-- The aid should be in Actor table but 57000 doesn't.
	-- Result:ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))
INSERT INTO Review VALUES('Hero', '2017-04-16 14:01:23', 49000, 6, 'I am the hero!');
	-- The mid should be in Movie table but 49000 doesn't.
	-- Result: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO Movie VALUES (1, 'Avengers', 2077, 'PG-13', 'Marvel');
	-- The year should be a valid number between 0 and 2018

INSERT INTO Actor VALUES (2, 'Bai', 'Jingting', 'Male', '2049-10-15', \N);
	-- The dob should be a valid date with year between 0 and 2018

INSERT INTO Director VALUES (2, 'Bai', 'Jingting', 'Male', '2049-10-15', \N);
	-- The dob should be a valid date with year between 0 and 2018
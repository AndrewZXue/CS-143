/* a */

CREATE TABLE scooter (
	scooter_id int NOT NULL,
	flag smallint NOT NULL,
	home varchar(30) NOT NULL,
	PRIMARY KEY (scooter_id)
	/* does not have a foreign key */
);

CREATE TABLE user (
	user_id int NOT NULL,
	credit int,
	expr date,
	email varchar(30) NOT NULL,
	PRIMARY KEY (user_id)
	/* does not have a foreign key */
);



/* b */

CREATE TABLE trip (
	trip_id int NOT NULL,
	scooter_id int NOT NULL,
	user_id int NOT NULL,
	start_location int NOT NULL,
	dest_location int NOT NULL,
	start_time time NOT NULL,
	end_time time NOT NULL,
	charge int NOT NULL,
	PRIMARY KEY (trip_id)
	/* foreign keys: scooter_id, user_id */
);


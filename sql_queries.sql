--Interesting fact, MySQL uses MyISAM as the default
--  engine (whatever an engine is), but it doesn't
--  support foreign keys. I've set InnoDB as our
--  engine for each table, that way we can use
--  foreign keys. Yay!

CREATE TABLE ZIPS(
	zip char(5) NOT NULL,
	city varchar(30) NOT NULL,
	state varchar(20) NOT NULL,
	PRIMARY KEY (zip)
)ENGINE = InnoDB;

CREATE TABLE USERS(
	user_id varchar(20) NOT NULL,
	email varchar(50) NOT NULL UNIQUE,
	password varchar(50) NOT NULL,
	zip char(5) NOT NULL,
	fname varchar(30) NOT NULL,
	lname varchar(30) NOT NULL,
	dob date,
	area varchar(20),
	PRIMARY KEY (user_id),
	FOREIGN KEY (zip) REFERENCES ZIPS(zip)
)ENGINE = InnoDB;

CREATE TABLE SUGGESTIONS(
	user_id varchar(20) NOT NULL,
	topic varchar(100) NOT NULL,
	stamp timestamp NOT NULL,
	suggestion text,
	PRIMARY KEY (user_id, stamp),
	FOREIGN KEY (user_id) REFERENCES USERS(user_id)
)ENGINE = InnoDB;

CREATE TABLE REFERS(
	user_id varchar(20) NOT NULL, 
	email varchar(50) NOT NULL,
	name varchar(60),
	PRIMARY KEY (user_id, email),
	FOREIGN KEY (user_id) REFERENCES USERS(user_id)
)ENGINE = InnoDB;

CREATE TABLE FRIENDS(
	user_id1 varchar(20) NOT NULL,
	user_id2 varchar(20) NOT NULL,
	pending boolean NOT NULL,
	PRIMARY KEY (user_id1, user_id2),
	FOREIGN KEY (user_id1) REFERENCES USERS(user_id),
	FOREIGN KEY (user_id2) REFERENCES USERS(user_id),
	CHECK (user_id1 != user_id2) 
)ENGINE = InnoDB;

CREATE TABLE MEDIA(
	media_id integer NOT NULL AUTO_INCREMENT,
	user_id varchar(20) NOT NULL,
	genre varchar(20) NOT NULL,
	title varchar(20) NOT NULL,
	type varchar(20) NOT NULL,
	author varchar(60),
	publisher varchar(40),
	ISBN varchar(40),
	artist varchar(60),
	writer varchar(60),
	director varchar(60),
	PRIMARY KEY (media_id),
	FOREIGN KEY (user_id) REFERENCES USERS(user_id)
)ENGINE = InnoDB;

CREATE TABLE BORROWS(
	user_id varchar(20) NOT NULL,
	media_id integer NOT NULL,
	status varchar(15) NOT NULL,
	start_date timestamp NOT NULL,
	return_date timestamp,
	PRIMARY KEY (user_id, media_id, start_date),
	FOREIGN KEY (user_id) REFERENCES USERS(user_id),
	FOREIGN KEY (media_id) REFERENCES MEDIA(media_id)
)ENGINE = InnoDB;

CREATE TABLE COMMENTS(
	user_id varchar(20) NOT NULL,
	media_id integer NOT NULL,
	comment text,
	rating integer,
	stamp timestamp NOT NULL,
	PRIMARY KEY (user_id, media_id),
	FOREIGN KEY (user_id) REFERENCES USERS(user_id),
	FOREIGN KEY (media_id) REFERENCES MEDIA(media_id)
)ENGINE = InnoDB;

INSERT INTO USERS
VALUES ('mike',
    'michaelwisely@gmail.com',
    '123',
    '65401',
    'Mike',
    'Wisely',
    '1989-09-21',
    'Movies');
    
INSERT INTO USERS
VALUES ('jared',
    'jared.d.simon@gmail.com',
    '123',
    '65401',
    'Jared',
    'Simon',
    '1989-08-16',
    'Music');
    
INSERT INTO USERS
VALUES ('kyle',
    'kyleellman@gmail.com',
    '123',
    '65401',
    'Kyle',
    'Ellman',
    '1989-01-01',
    'Books');

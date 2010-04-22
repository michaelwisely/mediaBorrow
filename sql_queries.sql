CREATE TABLE USER(
	user_id varchar(20) PRIMARY KEY,
	email varchar(50) UNIQUE NOT NULL,
	password varchar(50) NOT NULL,
	zip char(5),
	fname varchar(30),
	lname varchar(30)
	dob date,
	area varchar(20)
);

CREATE TABLE ZIP(
	zip char(5) PRIMARY KEY,
	city varchar(30),
	state varchar(20)
);

CREATE TABLE SUGGESTIONS(
	user_id varchar(20),
	topic varchar(100),
	stamp timestamp,
	suggestion text,
	PRIMARY KEY (user_id, stamp)
);

CREATE TABLE REFERENCE(
	uid varchar(20), 
	email varchar(50),
	name varchar(60),
	PRIMARY KEY (uid, email)
);

CREATE TABLE FRIEND(
	uid1 varchar(20),
	uid2 varchar(20),
	pending boolean NOT NULL,
	PRIMARY KEY (uid1, uid2)
);

CREATE TABLE MEDIA(
	media_id integer PRIMARY KEY,
	user_id varchar(20),
	genre varchar(20),
	title varchar(20),
	type varchar(20),
	author varchar(60)
	publisher varchar(40),
	ISBN varchar(40),
	artist varchar(60),
	writer varchar(60),
	director varchar(60)
);

CREATE TABLE BORROWS(
	user_id varchar(20),
	media_id integer,
	status varchar(15),
	start_date date,
	return_date date,
	PRIMARY KEY (user_id, media_id)
);

CREATE TABLE COMMENTS(
	user_id varchar(20),
	media_id integer
	comment text,
	stamp timestamp,
	PRIMARY KEY (user_id, media_id)
);
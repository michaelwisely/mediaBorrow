CREATE TABLE ZIPS( 
	zip char(5) NOT NULL, 
	city varchar(30) NOT NULL, 
	state varchar(20) NOT NULL, 
	PRIMARY KEY (zip) )
	ENGINE = InnoDB;
			
CREATE TABLE USERS( 
	user_id varchar(20) NOT NULL, 
	email varchar(50) NOT NULL UNIQUE, 
	password varchar(50) NOT NULL, 
	zip char(5) NOT NULL, 
	fname varchar(30) NOT NULL, 
	lname varchar(30) NOT NULL, 
	dob varchar(10), area varchar(20), 
	PRIMARY KEY (user_id), 
	FOREIGN KEY (zip) REFERENCES ZIPS(zip) )
	ENGINE = InnoDB;
			
CREATE TABLE SUGGESTIONS( 
	user_id varchar(20) NOT NULL, 
	topic varchar(100) NOT NULL, 
	time_stamp integer NOT NULL, 
	suggestion text, 
	PRIMARY KEY (user_id, time_stamp), 
	FOREIGN KEY (user_id) REFERENCES USERS(user_id) )
	ENGINE = InnoDB;
			
			
CREATE TABLE REFERS( 
	user_id varchar(20) NOT NULL, 
	email varchar(50) NOT NULL, 
	name varchar(60), 
	PRIMARY KEY (user_id, email), 
	FOREIGN KEY (user_id) REFERENCES USERS(user_id) )
	ENGINE = InnoDB;
			
			
CREATE TABLE FRIENDS( 
	user_id1 varchar(20) NOT NULL, 
	user_id2 varchar(20) NOT NULL, 
	pending varchar(5) NOT NULL, 
	PRIMARY KEY (user_id1, user_id2), 
	FOREIGN KEY (user_id1) REFERENCES USERS(user_id), 
	FOREIGN KEY (user_id2) REFERENCES USERS(user_id), 
	CHECK (user_id1 != user_id2) )
	ENGINE = InnoDB;
			
			
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
	FOREIGN KEY (user_id) REFERENCES USERS(user_id) )
	ENGINE = InnoDB;
			
			
CREATE TABLE BORROWS( 
	user_id varchar(20) NOT NULL, 
	media_id integer NOT NULL, 
	status varchar(15) NOT NULL, 
	start_date integer NOT NULL, 
	return_date integer, 
	PRIMARY KEY (user_id, media_id, start_date), 
	FOREIGN KEY (user_id) REFERENCES USERS(user_id), 
	FOREIGN KEY (media_id) REFERENCES MEDIA(media_id) )
	ENGINE = InnoDB;
			
			
CREATE TABLE COMMENTS( 
	user_id varchar(20) NOT NULL, 
	media_id integer NOT NULL, 
	comment text, 
	rating integer, 
	time_stamp integer NOT NULL, 
	PRIMARY KEY (user_id, media_id), 
	FOREIGN KEY (user_id) REFERENCES USERS(user_id), 
	FOREIGN KEY (media_id) REFERENCES MEDIA(media_id) )
	ENGINE = InnoDB;







			


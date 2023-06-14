CREATE TABLE IF NOT EXISTS users (
	id int NOT NULL AUTO_INCREMENT,
	username varchar(50) NOT NULL,
	email varchar(80) NOT NULL,
	password varchar(200) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS categories (
	id int NOT NULL AUTO_INCREMENT,
	name varchar(100) NOT NULL,
	creator int,
	PRIMARY KEY (id),
	FOREIGN KEY (creator) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS jobs (
	id int NOT NULL AUTO_INCREMENT,
	name varchar(100) NOT NULL,
	finished boolean DEFAULT FALSE,
	category varchar(100) NOT NULL,
	file varchar(100) DEFAULT NULL,
	creator int,
	created_at datetime NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (creator) REFERENCES users(id)
);

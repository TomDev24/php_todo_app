<?php
	$con = mysqli_connect("localhost", "root", "", "todoapp");
	if (mysqli_connect_errno())
		echo "Ошибка подключения к MySql";

/*
CREATE TABLE IF NOT EXISTS users (
	id int NOT NULL AUTO_INCREMENT,
	username varchar(20) NOT NULL,
	email varchar(50) NOT NULL,
	password varchar(500) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS projects (
	id int NOT NULL AUTO_INCREMENT,
	name varchar(40) NOT NULL,
	user_id int,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tasks (
	id int NOT NULL AUTO_INCREMENT,
	name varchar(100) NOT NULL,
	project_name varchar(40) NOT NULL,
	user_id int,
	is_done boolean DEFAULT FALSE,
	due_to datetime NOT NULL,
	file_name varchar(100) DEFAULT NULL,
	PRIMARY KEY (id)
);
*/
?>

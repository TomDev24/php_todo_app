# Дела в порядке - простой список дел на PHP и MySQL

## Настройка проекта

Для работы базы данных, нужно создать следующие таблицы

```
CREATE TABLE IF NOT EXISTS users (
        id int NOT NULL AUTO_INCREMENT,
        username varchar(40) NOT NULL,
        email varchar(40) NOT NULL,
        password varchar(400) NOT NULL,
        PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS projects (
        id int NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        user int NOT NULL,
        PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tasks (
        id int NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        project varchar(100) NOT NULL,
        user int NOT NULL,
        is_done boolean DEFAULT FALSE,
        date_complete datetime NOT NULL,
        file varchar(100) DEFAULT NULL,
        PRIMARY KEY (id)
);
``` 

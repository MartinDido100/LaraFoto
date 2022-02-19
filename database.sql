CREATE DATABASE IF NOT EXISTS laraver_master;

USE laraver_master;

CREATE TABLE users(
id INT(255) AUTO_INCREMENT NOT NULL,
role VARCHAR(20) NOT NULL,
name VARCHAR(100) NOT NULL,
surname VARCHAR(200) NOT NULL
nick VARCHAR(100) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
image VARCHAR(255) NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL,
remember_token VARCHAR(255) NOT NULL,
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDB;

INSERT INTO users VALUES(null,'user','Victor','Robles','victorroblesweb','victor@victor.com','pass',null,CURTIME(),CURTIME(),null);

CREATE TABLE IF NOT EXISTS images(
id INT(255) AUTO_INCREMENT NOT NULL,
user_id INT(255),
image_path VARCHAR(255) NOT NULL,
description TEXT,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comments(
id INT(255) AUTO_INCREMENT NOT NULL,   
user_id INT(255),
image_id INT(255),
content TEXT NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS likes(
id INT(255) AUTO_INCREMENT NOT NULL,   
user_id INT(255),
image_id INT(255),
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDB;


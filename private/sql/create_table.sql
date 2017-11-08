CREATE TABLE subject (
    id INT(11) NOT NULL AUTO_INCREMENT, 
    menu_name VARCHAR(255) NOT NULL,
    position INT(3) NOT NULL, 
    visible TINYINT(1) NOT NULL DEFAULT 0,
    
    PRIMARY KEY(id)
);

CREATE TABLE page (
    id INT(11) NOT NULL AUTO_INCREMENT, 
    subject_id INT(11) NOT NULL, 
    menu_name VARCHAR(255) NOT NULL,
    position INT(3) NOT NULL,
    visible TINYINT(1) NOT NULL DEFAULT 0,
    content TEXT NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(subject_id) 
    REFERENCES subject(id), 
    INDEX(subject_id)
);

CREATE TABLE admin (
	id INT(11) NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(255) NOT NULL,
	last_name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL UNIQUE,
	hashed_password VARCHAR(255) NOT NULL,

	PRIMARY KEY(id),
	INDEX(username)
);
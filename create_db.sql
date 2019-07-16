create table users(
id INT NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(50) NOT NULL,
surname VARCHAR(50) NOT NULL,
gender ENUM('male', 'female') NOT NULL,
group_number VARCHAR(5) NOT NULL,
email VARCHAR(60) NOT NULL UNIQUE, 
exam_score INT NOT NULL, 
birth_year YEAR NOT NULL, 
place ENUM('local', 'nonlocal') NOT NULL,
auth_key VARCHAR(32) NOT NULL
);


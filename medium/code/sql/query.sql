DROP DATABASE fintech; --kalau first time boleh dikomen
CREATE DATABASE fintech;
USE fintech;

CREATE TABLE client (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50),
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(127) NOT NULL
);

CREATE TABLE customer(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(127) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  link VARCHAR(255) NOT NULL UNIQUE,
  passport_path VARCHAR(255),
  video_path VARCHAR(255),
  passport_number VARCHAR(30),
  birth_date DATE,
  nationality VARCHAR(50),
  country VARCHAR(50),
  phone VARCHAR(20),
  occupation VARCHAR(40),
  address VARCHAR(127)
);

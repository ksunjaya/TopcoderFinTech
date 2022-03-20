DROP DATABASE fintech; --kalau first time boleh dikomen
CREATE DATABASE fintech;
USE fintech;

CREATE TABLE client (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(127) NOT NULL
);
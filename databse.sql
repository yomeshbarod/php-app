CREATE USER 'yomesh'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON *BookStore* TO 'yomesh'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

Create database
CREATE DATABASE bookstore;
USE bookstore;
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL
);

INSERT INTO books (title, author) VALUES
('Clean Code', 'Robert C. Martin\'),
('The Pragmatic Programmer', 'Andrew Hunt'),
('Design Patterns', 'Erich Gamma');

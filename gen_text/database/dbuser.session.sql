CREATE TABLE IF NOT EXISTS users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
    first_name VARCHAR(255) NOT NULL
    last_name VARCHAR(255) NOT NULL
);
INSERT INTO users (username, password_hash,first_name,last_name) VALUES ('TEST5', '123456789','testos3','veliky3')
SELECT *
FROM users;


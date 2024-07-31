--
-- THIS FILE WILL CREATE A USER WITH USERNAME 'testuser' AND PASSWORD 'password' 
-- FOR USE WITH PHP PDO IN THE WEB APPLICATION
--
CREATE USER 'testuser'@'localhost' IDENTIFIED WITH authentication_plugin BY 'password';
GRANT * ON sampdb TO 'testuser'@'localhost';

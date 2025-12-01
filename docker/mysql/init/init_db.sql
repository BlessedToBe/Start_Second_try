CREATE DATABASE app CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE USER 'admin'@'%' IDENTIFIED WITH mysql_native_password AS 'DFwe3@1xbRE2^@#';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%';

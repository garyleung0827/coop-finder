--
-- Database: `movies` and php web application user
CREATE DATABASE IF NOT EXISTS coop;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON coop.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE coop;

CREATE TABLE IF NOT EXISTS `coop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `source` varchar(100) NOT NULL,
  `pubDate` varchar(100) NOT NULL,
 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
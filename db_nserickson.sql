-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 27, 2017 at 02:23 PM
-- Server version: 5.6.33-cll-lve
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_nserickson`
--

-- --------------------------------------------------------

--
-- Table structure for table `Files`
--

CREATE TABLE IF NOT EXISTS `Files` (
  `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(50) NOT NULL,
  `Class` varchar(50) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `Files`
--

INSERT INTO `Files` (`file_id`, `file_name`, `Class`) VALUES
(1, 'account.php', 'Informatics_Project'),
(2, 'calendar.php', 'Informatics_Project'),
(3, 'config.php', 'Informatics_Project'),
(4, 'create_users.php', 'Informatics_Project'),
(5, 'createsite.php', 'Informatics_Project'),
(6, 'db.sh', 'Informatics_Project'),
(7, 'dbutils.php', 'Informatics_Project'),
(8, 'deleteorgs.php', 'Informatics_Project'),
(9, 'deletepage.php', 'Informatics_Project'),
(10, 'editpage.php', 'Informatics_Project'),
(11, 'edituser.php', 'Informatics_Project'),
(12, 'getAccType.php', 'Informatics_Project'),
(13, 'getuid.php', 'Informatics_Project'),
(14, 'index.php', 'Informatics_Project'),
(15, 'home.php', 'Informatics_Project'),
(16, 'input.php', 'Informatics_Project'),
(17, 'insertpage.php', 'Informatics_Project'),
(18, 'reset.php', 'Informatics_Project'),
(19, 'reset_user.php', 'Informatics_Project'),
(20, 'styles.css', 'Informatics_Project'),
(21, 'tables.sql', 'Informatics_Project'),
(22, 'full_project.zip', 'Informatics_Project'),
(23, 'AboutMe.zip', 'HTML5'),
(24, 'Canvas1.html', 'HTML5'),
(25, 'Canvas2.html', 'HTML5'),
(26, 'Changing.zip', 'HTML5'),
(27, 'Classes.py', 'Python'),
(28, 'ClientTCP.py', 'Python'),
(29, 'ClientUDP.py', 'Python'),
(30, 'fruitsAndVeggies.py', 'Python'),
(31, 'GoogleMapsApi.html', 'HTML5'),
(32, 'GoogleMapsApi2.html', 'HTML5'),
(33, 'Hanoi1.py', 'Python'),
(34, 'HW03.zip', 'C++'),
(35, 'HW04.zip', 'C++'),
(36, 'interactive.zip', 'HTML5'),
(37, 'lists.py', 'Python'),
(38, 'sDES.py', 'Python'),
(39, 'ServerTCP.py', 'Python'),
(40, 'ServerUDP.py', 'Python'),
(41, 'book.cpp', 'C++'),
(42, 'book.h', 'C++'),
(43, 'book_main.cpp', 'C++'),
(44, 'complex.cpp', 'C++'),
(45, 'complex.h', 'C++'),
(46, 'book.cpp', 'C++'),
(47, 'fractal_main.cpp', 'C++'),
(48, 'list.cpp', 'C++'),
(49, 'list.h', 'C++'),
(50, 'loadfile.cpp', 'C++'),
(51, 'lodepng.cpp', 'C++'),
(52, 'lodepng.h', 'C++'),
(53, 'rgb.h', 'C++');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE IF NOT EXISTS `organizations` (
  `orgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orgName` varchar(50) NOT NULL,
  `footerText` varchar(200) NOT NULL,
  `stylesheetid` int(11) NOT NULL,
  `verified` varchar(3) NOT NULL,
  PRIMARY KEY (`orgid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`orgid`, `orgName`, `footerText`, `stylesheetid`, `verified`) VALUES
(1, 'Iowa Powerlifting Club', '&copy; 2016 Iowa Powerlifting Club. All Rights Reserved.', 2, 'yes'),
(2, 'My Site', 'My Site Right reserved', 9, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urlTitle` varchar(32) NOT NULL,
  `pageTitle` varchar(32) NOT NULL,
  `menuTitle` varchar(32) NOT NULL,
  `orgid` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `bodyTitle` varchar(128) NOT NULL,
  `body` text,
  `asideTitle` varchar(128) DEFAULT NULL,
  `asideBody` text,
  `template` int(11) NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `urlTitle`, `pageTitle`, `menuTitle`, `orgid`, `parent`, `bodyTitle`, `body`, `asideTitle`, `asideBody`, `template`, `image`) VALUES
(1, 'Home', 'Home - Iowa Powerlifting Club', 'Home', 1, -1, 'Welcome to the Iowa Powerlifting Club', 'Weights, weights, and more weights.', 'News', 'Welcome to the club. Stay up to date with our events.', 2, 'IPL2.png'),
(2, 'home', 'My Site', 'Home', 2, -1, 'Welcome', 'sijbfij s ajdboaf sjbdos .', NULL, NULL, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `pUsers`
--

CREATE TABLE IF NOT EXISTS `pUsers` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `birthday` varchar(10) NOT NULL,
  `email` varchar(128) NOT NULL,
  `acctype` varchar(20) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `hashedpass` varchar(200) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pUsers`
--

INSERT INTO `pUsers` (`uid`, `fname`, `lname`, `birthday`, `email`, `acctype`, `username`, `hashedpass`) VALUES
(1, 'Nicholas', 'Erickson', '09/27/1993', 'nicholas-erickson@uiowa.edu', 'admin', 'nserickson', '$2a$12$sOdb2AszxFwZ5ugtcJyU3upel/16dUJC/G5w.3c19btV4vya0eW4W'),
(2, 'Malachi', 'Melville', '12/20/1993', 'malachi-melville@uiowa.edu', 'admin', 'mtmelville', '$2a$12$fkpGCLJWoAG2qLUX0/4EY.XJLncna0I3RiNk2yx43SNg6XTQGez1O'),
(3, 'Jacob', 'Sikorski', '02/04/1995', 'jacob-sikorski@uiowa.edu', 'admin', 'jsikorski', '$2a$12$OS3/Tq5hKPNXVLAqL/ud.e9mJlxWop7lK2PSTD9ifTcGOgd2zS0om'),
(4, 'Jacob', 'Erickson', '07/11/1995', 'jacob@live.com', '', 'Jlerickson', '$2a$12$61H7Ml3cQC6kPKBSGTLaIu4QBI3jqKGeOr./mV/vm8zgWWLP4BHG2');

-- --------------------------------------------------------

--
-- Table structure for table `stylesheets`
--

CREATE TABLE IF NOT EXISTS `stylesheets` (
  `sheetid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sheetName` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `link` varchar(200) NOT NULL,
  `thumbnail` varchar(200) NOT NULL,
  PRIMARY KEY (`sheetid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `stylesheets`
--

INSERT INTO `stylesheets` (`sheetid`, `sheetName`, `description`, `link`, `thumbnail`) VALUES
(1, 'Cosmo', '', 'https://bootswatch.com/cosmo/bootstrap.min.css', 'https://bootswatch.com/cosmo/thumbnail.png'),
(2, 'Cyborg', '', 'https://bootswatch.com/cyborg/bootstrap.min.css', 'https://bootswatch.com/cyborg/thumbnail.png'),
(3, 'Darkly', '', 'https://bootswatch.com/darkly/bootstrap.min.css', 'https://bootswatch.com/darkly/thumbnail.png'),
(4, 'Flatly', '', 'https://bootswatch.com/flatly/bootstrap.min.css', 'https://bootswatch.com/flatly/thumbnail.png'),
(5, 'Journal', '', 'https://bootswatch.com/journal/bootstrap.min.css', 'https://bootswatch.com/journal/thumbnail.png'),
(6, 'Lumen', '', 'https://bootswatch.com/lumen/bootstrap.min.css', 'https://bootswatch.com/lumen/thumbnail.png'),
(7, 'Paper', '', 'https://bootswatch.com/paper/bootstrap.min.css', 'https://bootswatch.com/paper/thumbnail.png'),
(8, 'Readable', '', 'https://bootswatch.com/readable/bootstrap.min.css', 'https://bootswatch.com/readable/thumbnail.png'),
(9, 'Sandstone', '', 'https://bootswatch.com/sandstone/bootstrap.min.css', 'https://bootswatch.com/sandstone/thumbnail.png'),
(10, 'Simplex', '', 'https://bootswatch.com/simplex/bootstrap.min.css', 'https://bootswatch.com/simplex/thumbnail.png'),
(11, 'Slate', '', 'https://bootswatch.com/slate/bootstrap.min.css', 'https://bootswatch.com/slate/thumbnail.png'),
(12, 'Spacelab', '', 'https://bootswatch.com/spacelab/bootstrap.min.css', 'https://bootswatch.com/spaelab/thumbnail.png'),
(13, 'Superhero', '', 'https://bootswatch.com/superhero/bootstrap.min.css', 'https://bootswatch.com/superhero/thumbnail.png'),
(14, 'United', '', 'https://bootswatch.com/united/bootstrap.min.css', 'https://bootswatch.com/united/thumbnail.png'),
(15, 'Yeti', '', 'https://bootswatch.com/yeti/bootstrap.min.css', 'https://bootswatch.com/yeti/thumbnail.png'),
(16, 'Cerulean', '', 'https://bootswatch.com/cerulean/bootstrap.min.css', 'https://bootswatch.com/cerulean/thumbnail.png');

-- --------------------------------------------------------

--
-- Table structure for table `userorg`
--

CREATE TABLE IF NOT EXISTS `userorg` (
  `orgid` int(11) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `orgacctype` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userorg`
--

INSERT INTO `userorg` (`orgid`, `uid`, `orgacctype`) VALUES
(1, 1, 'orgadmin'),
(1, 2, 'orgadmin'),
(2, 4, 'orgadmin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

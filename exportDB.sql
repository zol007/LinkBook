-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2016 at 03:56 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linkbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID_category` int(11) NOT NULL,
  `name` varchar(65) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `ID_user` int(11) DEFAULT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `ID_image` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `source_name` varchar(100) DEFAULT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `last_modified` datetime DEFAULT NULL,
  `ID_category` int(11) DEFAULT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `ID_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `image_tag`
--

CREATE TABLE `image_tag` (
  `ID_imagetag` int(11) NOT NULL,
  `ID_image` int(11) NOT NULL,
  `ID_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `know`
--

CREATE TABLE `know` (
  `ID_know` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `last_modified` datetime NOT NULL,
  `ID_category` int(11) DEFAULT NULL,
  `priority` tinyint(1) DEFAULT '0',
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `ID_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `know_tag`
--

CREATE TABLE `know_tag` (
  `ID_knowtag` int(11) NOT NULL,
  `ID_know` int(11) NOT NULL,
  `ID_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `link`
--

CREATE TABLE `link` (
  `ID_link` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `URL` varchar(200) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `last_modified` datetime DEFAULT NULL,
  `ID_category` int(11) DEFAULT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `ID_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `link_tag`
--

CREATE TABLE `link_tag` (
  `ID_linktag` int(11) NOT NULL,
  `ID_link` int(11) NOT NULL,
  `ID_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `ID_tag` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID_user` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID_category`,`type`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`ID_image`);
ALTER TABLE `image` ADD FULLTEXT KEY `name_fullindex` (`name`);

--
-- Indexes for table `image_tag`
--
ALTER TABLE `image_tag`
  ADD PRIMARY KEY (`ID_imagetag`);

--
-- Indexes for table `know`
--
ALTER TABLE `know`
  ADD PRIMARY KEY (`ID_know`);
ALTER TABLE `know` ADD FULLTEXT KEY `name` (`name`,`content`);

--
-- Indexes for table `know_tag`
--
ALTER TABLE `know_tag`
  ADD PRIMARY KEY (`ID_knowtag`);

--
-- Indexes for table `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`ID_link`);
ALTER TABLE `link` ADD FULLTEXT KEY `name_fullindex` (`name`,`URL`);

--
-- Indexes for table `link_tag`
--
ALTER TABLE `link_tag`
  ADD PRIMARY KEY (`ID_linktag`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`ID_tag`);
ALTER TABLE `tag` ADD FULLTEXT KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `ID_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `image_tag`
--
ALTER TABLE `image_tag`
  MODIFY `ID_imagetag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `know`
--
ALTER TABLE `know`
  MODIFY `ID_know` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `know_tag`
--
ALTER TABLE `know_tag`
  MODIFY `ID_knowtag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `link`
--
ALTER TABLE `link`
  MODIFY `ID_link` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `link_tag`
--
ALTER TABLE `link_tag`
  MODIFY `ID_linktag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `ID_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

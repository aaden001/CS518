-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2018 at 06:31 PM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `Administrators`
--
CREATE DATABASE Chat;

CREATE TABLE `Chat`.`Administrators` (
  `UserID` int(11) NOT NULL,
  `RoomsID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Administrators`
--

INSERT INTO `Chat`.`Administrators` (`UserID`, `RoomsID`) VALUES
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `ChatBox`
--

CREATE TABLE `Chat`.`ChatBox` (
  `ID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TextA` varchar(400) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- AUTO_INCREMENT for table `ChatBox`
--
ALTER TABLE `Chat`.`ChatBox`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Dumping data for table `ChatBox`
--

INSERT INTO `Chat`.`ChatBox` (`ID`, `RoomID`, `UserID`, `TextA`, `created_at`) VALUES
(1, 1, 1, '&lt;b&gt; This is my Real Face O&lt;/b&gt;', '2018-10-14 03:57:04'),
(2, 1, 1, '&lt;b&gt; This is my Real Face O&lt;/b&gt; !@#$%%()&lt;&gt;?/}{}^', '2018-10-14 04:04:58'),
(3, 1, 1, '&lt;b&gt; This is my Real Face O&lt;/b&gt; !@#$%%()&lt;&gt;?/}{}^', '2018-10-14 04:05:31'),
(4, 1, 1, '&lt;b&gt; This is my Real Face O&lt;/b&gt; .....,,,', '2018-10-14 04:16:07'),
(5, 1, 1, '&lt;b&gt; I am here &lt;/b&gt; ,......!@#$%^&amp;**((())??', '2018-10-14 05:09:36'),
(6, 3, 3, 'babaert342452452wrgar', '2018-10-15 01:08:38'),
(7, 1, 2, 'I said spmething By sally', '2018-10-15 01:10:26'),
(8, 1, 3, 'Doc is here', '2018-10-15 01:10:43'),
(9, 1, 4, 'finne too came here', '2018-10-15 01:11:01'),
(10, 1, 5, 'Lightning is bright ', '2018-10-15 01:11:25'),
(11, 1, 2, 'Sally here again boys', '2018-10-15 01:24:03'),
(12, 1, 5, 'Lighting will burn you', '2018-10-15 01:24:38'),
(13, 1, 2, 'Hey Mater', '2018-10-16 00:10:03'),
(14, 1, 2, 'I am sally you welcome &lt;b&gt; BOLD&lt;/b&gt;', '2018-10-16 00:10:50'),
(16, 2, 1, 'hello', '2018-11-22 08:34:34'),
(17, 2, 1, 'this is amazing', '2018-11-22 08:34:45'),
(18, 2, 1, 'yes boy', '2018-11-22 20:53:41');

-- --------------------------------------------------------

--
-- Table structure for table `ChatLikes`
--

CREATE TABLE `Chat`.`ChatLikes` (
  `chatID` int(11) NOT NULL,
  `userRateID` int(11) NOT NULL,
  `rating` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ChatLikes`
--

INSERT INTO `Chat`.`ChatLikes` (`chatID`, `userRateID`, `rating`) VALUES
(6, 1, 'like'),
(16, 1, 'like'),
(17, 1, 'like'),
(18, 1, 'like');

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

CREATE TABLE `Chat`.`Comment` (
  `Id` int(11) NOT NULL,
  `ChatBoxID` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `TextArea` varchar(400) NOT NULL,
  `Ccreated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `thread` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- AUTO_INCREMENT for table `Comment`
--
ALTER TABLE `Chat`.`Comment`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Dumping data for table `Comment`
--

INSERT INTO `Chat`.`Comment` (`Id`, `ChatBoxID`, `userId`, `TextArea`, `Ccreated_at`, `thread`) VALUES
(1, 16, 1, 'chicken shit', '2018-11-22 20:55:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `InviteLinks`
--

CREATE TABLE `Chat`.`InviteLinks` (
  `AdminID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `link` varchar(50) NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `InviteLinks`
--

INSERT INTO `Chat`.`InviteLinks` (`AdminID`, `userID`, `RoomID`, `link`, `flag`) VALUES
(6, 1, 3, 'getInvite.php?adminID=6&userId=1', 1),
(6, 6, 1, 'getInvite.php?adminID=6&userId=6', 1),
(6, 1, 1, 'getInvite.php?adminID=6&userId=1', 1),
(6, 1, 1, 'getInvite.php?adminID=6&userId=1', 1),
(6, 1, 1, 'getInvite.php?adminID=6&userId=1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ProfilePictures`
--

CREATE TABLE `Chat`.`ProfilePictures` (
  `ID` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `pictureLink` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- AUTO_INCREMENT for table `ProfilePictures`
--
ALTER TABLE `Chat`.`ProfilePictures`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Dumping data for table `ProfilePictures`
--

INSERT INTO `Chat`.`ProfilePictures` (`ID`, `userId`, `pictureLink`) VALUES
(1, 1, '../ProfilePics/test.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE `Chat`.`Rooms` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `grpTyp` int(1) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- AUTO_INCREMENT for table `Rooms`
--
ALTER TABLE `Chat`.`Rooms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Dumping data for table `Rooms`
--

INSERT INTO `Chat`.`Rooms` (`ID`, `Name`, `grpTyp`, `active`) VALUES
(1, 'Global', 0, 1),
(2, 'Teens', 1, 1),
(3, 'FootBall', 1, 1),
(4, 'Music', 1, 0),
(5, 'MatersNewGroup', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `UserGroups`
--

CREATE TABLE `Chat`.`UserGroups` (
  `UserID` int(11) NOT NULL,
  `RoomsID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `UserGroups`
--

INSERT INTO `Chat`.`UserGroups` (`UserID`, `RoomsID`) VALUES
(2, 1),
(3, 1),
(5, 1),
(1, 2),
(5, 4),
(3, 3),
(1, 3),
(1, 5),
(6, 1),
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Chat`.`Users` (
  `userId` int(11) NOT NULL,
  `userFullName` varchar(50) NOT NULL,
  `userEmail` varchar(30) NOT NULL,
  `userHandle` varchar(11) NOT NULL,
  `userPassword` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Chat`.`Users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;
--
-- Dumping data for table `Users`
--

INSERT INTO `Chat`.`Users` (`userId`, `userFullName`, `userEmail`, `userHandle`, `userPassword`) VALUES
(1, 'Tow Mater', 'mater@rsprings.gov', '@mater', 'mater'),
(2, 'Sally Carrera', 'porsche@rsprings.gov', '@sally', '@sally'),
(3, 'Doc Hudson', 'hornet@rsprings.gov', '@doc', '@doc'),
(4, 'Finn McMissile', 'topsecret@agent.org', '@mcmissle', '@mcmissle'),
(5, 'Lightning McQueen', 'kachow@rusteze.com', '@mcqueen', '@mcmqueen'),
(6, 'Adeniran Adeniyi', 'aaden001@odu.edu', '@aaden001', 'root');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Administrators`
--
ALTER TABLE `Chat`.`Administrators`
  ADD KEY `Administrators_Rooms_fk` (`RoomsID`),
  ADD KEY `Administrators_Users_fk` (`UserID`);

--
-- Indexes for table `ChatBox`
--
ALTER TABLE `Chat`.`ChatBox`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ChatBox_Rooms_fk` (`RoomID`),
  ADD KEY `ChatBox_UserID_fk` (`UserID`);

--
-- Indexes for table `ChatLikes`
--
ALTER TABLE `Chat`.`ChatLikes`
  ADD UNIQUE KEY `chatID` (`chatID`,`userRateID`),
  ADD KEY `ChatLikes_UserID_fk` (`userRateID`);

--
-- Indexes for table `Comment`
--
ALTER TABLE `Chat`.`Comment`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Comment_ChatMsgId_fk` (`ChatBoxID`),
  ADD KEY `Comment_UserId_fk` (`userId`);

--
-- Indexes for table `InviteLinks`
--
ALTER TABLE `Chat`.`InviteLinks`
  ADD KEY `InviteLinks_AdminUsers_fk` (`AdminID`),
  ADD KEY `InviteLinks_InviteeUsers_fk` (`userID`),
  ADD KEY `InviteLinks_roomID_fk` (`RoomID`);

--
-- Indexes for table `ProfilePictures`
--
ALTER TABLE `Chat`.`ProfilePictures`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Rooms`
--
ALTER TABLE `Chat`.`Rooms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserGroups`
--
ALTER TABLE `Chat`.`UserGroups`
  ADD KEY `UserGroups_Rooms_fk` (`RoomsID`),
  ADD KEY `UserGroups_Users_fk` (`UserID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Chat`.`Users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--





--
-- Constraints for dumped tables
--

--
-- Constraints for table `Administrators`
--
ALTER TABLE `Chat`.`Administrators`
  ADD CONSTRAINT `Administrators_Rooms_fk` FOREIGN KEY (`RoomsID`) REFERENCES `Rooms` (`ID`),
  ADD CONSTRAINT `Administrators_Users_fk` FOREIGN KEY (`UserID`) REFERENCES `Users` (`userId`);

--
-- Constraints for table `ChatBox`
--
ALTER TABLE `Chat`.`ChatBox`
  ADD CONSTRAINT `ChatBox_Rooms_fk` FOREIGN KEY (`RoomID`) REFERENCES `Rooms` (`ID`),
  ADD CONSTRAINT `ChatBox_UserID_fk` FOREIGN KEY (`UserID`) REFERENCES `Users` (`userId`);

--
-- Constraints for table `ChatLikes`
--
ALTER TABLE `Chat`.`ChatLikes`
  ADD CONSTRAINT `ChatLikes_ChatMsgId_fk` FOREIGN KEY (`chatID`) REFERENCES `ChatBox` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `ChatLikes_UserID_fk` FOREIGN KEY (`userRateID`) REFERENCES `Users` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `Comment`
--
ALTER TABLE `Chat`.`Comment`
  ADD CONSTRAINT `Comment_ChatMsgId_fk` FOREIGN KEY (`ChatBoxID`) REFERENCES `ChatBox` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Comment_UserId_fk` FOREIGN KEY (`userId`) REFERENCES `Users` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `InviteLinks`
--
ALTER TABLE `Chat`.`InviteLinks`
  ADD CONSTRAINT `InviteLinks_AdminUsers_fk` FOREIGN KEY (`AdminID`) REFERENCES `Users` (`userId`),
  ADD CONSTRAINT `InviteLinks_InviteeUsers_fk` FOREIGN KEY (`userID`) REFERENCES `Users` (`userId`),
  ADD CONSTRAINT `InviteLinks_roomID_fk` FOREIGN KEY (`RoomID`) REFERENCES `Rooms` (`ID`);

--
-- Constraints for table `UserGroups`
--
ALTER TABLE `Chat`.`UserGroups`
  ADD CONSTRAINT `UserGroups_Rooms_fk` FOREIGN KEY (`RoomsID`) REFERENCES `Rooms` (`ID`),
  ADD CONSTRAINT `UserGroups_Users_fk` FOREIGN KEY (`UserID`) REFERENCES `Users` (`userId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

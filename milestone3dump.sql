CREATE DATABASE Chat;

CREATE TABLE `Chat`.`Users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userFullName` varchar(50) NOT NULL,
  `userEmail` varchar(30) NOT NULL,
  `userHandle` varchar(11) NOT NULL,
  `userPassword` varchar(11) NOT NULL,
 PRIMARY KEY ( `userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `Chat`.`Users` (`userFullName`, `userEmail`, `userHandle`, `userPassword`) VALUES
('Tow Mater', 'mater@rsprings.gov', '@mater', 'mater'),
('Sally Carrera', 'porsche@rsprings.gov', '@sally', '@sally'),
('Doc Hudson', 'hornet@rsprings.gov', '@doc', '@doc'),
( 'Finn McMissile', 'topsecret@agent.org', '@mcmissle', '@mcmissle'),
( 'Lightning McQueen', 'kachow@rusteze.com', '@mcqueen', '@mcmqueen');


CREATE TABLE `Chat`.`Rooms` (
  `ID` int(11) NOT NULL  AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
`grpTyp` int(1) NOT NULL,
PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `Chat`.`Rooms` (`Name`,`grpTyp`) VALUES
('Global',0),
( 'Teens',1),
( 'FootBall',1),
( 'Music',1);


CREATE TABLE `Chat`.`UserGroups` (
  `UserID` int(11) NOT NULL,
  `RoomsID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Chat`.`UserGroups`
  ADD CONSTRAINT `UserGroups_Rooms_fk` FOREIGN KEY (`RoomsID`) REFERENCES `Rooms` (`ID`),
  ADD CONSTRAINT `UserGroups_Users_fk` FOREIGN KEY (`UserID`) REFERENCES `Users` (`userId`);


INSERT INTO `Chat`.`UserGroups` (`UserID`, `RoomsID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(1, 2),
(5, 4),
(3, 3);

CREATE TABLE `Chat`.`ChatBox` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RoomID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TextA` varchar(400) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY ( `ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Chat`.`ChatBox`
  ADD CONSTRAINT `ChatBox_Rooms_fk` FOREIGN KEY (`RoomID`) REFERENCES `Rooms` (`ID`),
  ADD CONSTRAINT `ChatBox_UserID_fk` FOREIGN KEY (`UserID`) REFERENCES `Users` (`userId`);



INSERT INTO `Chat`.`ChatBox` ( `RoomID`, `UserID`, `TextA`, `created_at`) VALUES
( 1, 1, '&lt;b&gt; This is my Real Face O&lt;/b&gt;', '2018-10-13 23:57:04'),
( 1, 1, '&lt;b&gt; This is my Real Face O&lt;/b&gt; !@#$%%()&lt;&gt;?/}{}^', '2018-10-14 00:04:58'),
(1, 1, '&lt;b&gt; This is my Real Face O&lt;/b&gt; !@#$%%()&lt;&gt;?/}{}^', '2018-10-14 00:05:31'),
( 1, 1, '&lt;b&gt; This is my Real Face O&lt;/b&gt; .....,,,', '2018-10-14 00:16:07'),
( 1, 1, '&lt;b&gt; I am here &lt;/b&gt; ,......!@#$%^&amp;**((())??', '2018-10-14 01:09:36'),
(3, 3, 'babaert342452452wrgar', '2018-10-14 21:08:38'),
(1, 2, 'I said spmething By sally', '2018-10-14 21:10:26'),
( 1, 3, 'Doc is here', '2018-10-14 21:10:43'),
(1, 4, 'finne too came here', '2018-10-14 21:11:01'),
( 1, 5, 'Lightning is bright ', '2018-10-14 21:11:25'),
(1, 2, 'Sally here again boys', '2018-10-14 21:24:03'),
(1, 5, 'Lighting will burn you', '2018-10-14 21:24:38'),
(1, 2, 'Hey Mater', '2018-10-15 20:10:03'),
(1, 2, 'I am sally you welcome &lt;b&gt; BOLD&lt;/b&gt;', '2018-10-15 20:10:50');

CREATE TABLE `Chat`.`Administrators` (
  `UserID` int(11) NOT NULL,
  `RoomsID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Chat`.`Administrators`
  ADD CONSTRAINT `Administrators_Rooms_fk` FOREIGN KEY (`RoomsID`) REFERENCES `Rooms` (`ID`),
  ADD CONSTRAINT `Administrators_Users_fk` FOREIGN KEY (`UserID`) REFERENCES `Users` (`userId`);


CREATE TABLE `Chat`.`InviteLinks` (
  `AdminID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
`RoomID` int(11) NOT NULL,
`link` varchar(50) NOT NULL,
`flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Chat`.`InviteLinks`
  ADD CONSTRAINT `InviteLinks_AdminUsers_fk` FOREIGN KEY (`AdminID`) REFERENCES `Users` (`userId`),
  ADD CONSTRAINT `InviteLinks_InviteeUsers_fk` FOREIGN KEY (`userID`) REFERENCES `Users` (`userId`),
  ADD CONSTRAINT `InviteLinks_roomID_fk` FOREIGN KEY (`RoomID`) REFERENCES `Rooms`(`ID`);


CREATE TABLE `Chat`.`ChatLikes` (

 `chatID` INT(11) NOT NULL ,
 `userRateID` INT(11) NOT NULL ,
 `rating` VARCHAR(20) NOT NULL ,
 UNIQUE (`chatID`, `userRateID`)
) ENGINE = InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `Chat`.`ChatLikes`
  ADD CONSTRAINT `ChatLikes_ChatMsgId_fk` FOREIGN KEY (`chatID`) REFERENCES `ChatBox` (`ID`),
  ADD CONSTRAINT `ChatLikes_UserID_fk` FOREIGN KEY (`userRateID`) REFERENCES `Users` (`userId`);


CREATE TABLE `Chat`.`ProfilePictures` (
  `ID` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `pictureLink` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Chat`.`ProfilePictures`
  ADD PRIMARY KEY (`ID`);
ALTER TABLE `Chat`.`ProfilePictures`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE   `Chat`.`Comment` (
  `Id` int(11)  NOT NULL AUTO_INCREMENT,
`ChatBoxID` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `TextArea` varchar(400) NOT NULL,
  `Ccreated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`thread` int(11)  NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Chat`.`Comment`
  ADD CONSTRAINT `Comment_ChatMsgId_fk` FOREIGN KEY (`ChatBoxID`) REFERENCES `ChatBox` (`ID`),
  ADD CONSTRAINT `Comment_UserId_fk` FOREIGN KEY (`userId`) REFERENCES `Users` (`userId`);

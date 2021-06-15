CREATE DATABASE ersh_db;

USE ersh_db;

CREATE TABLE `user` (
    `UserID` int(11) NOT NULL auto_increment,
    `username`varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `created_at` datetime default NOW(),
    PRIMARY KEY (`UserID`)
);

CREATE TABLE `requests` (
    `RequestID` int(11) NOT NULL auto_increment,
    `StationID` int(11) NOT NULL,
    `UserID` int(11) NOT NULL,
    `contact_number` varchar(255) NOT NULL,
    `litre` float NOT NULL,
    `created_at` datetime default NOW(),
    PRIMARY KEY (`RequestID`)
);

CREATE TABLE `quote` (
    `QuoteID` int(11) NOT NULL auto_increment,
    `RequestID` int(11) NOT NULL,
    `UserID` int(11) NOT NULL,
    `delivery_fee` float NOT NULL,
    `litre_fee` float NOT NULL,
    `isAccepted` int(11) default -1,
    `created_at` datetime default NOW(),
    PRIMARY KEY (`QuoteID`)
);

CREATE TABLE `stations` (
    `StationID` int(11) NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `code` varchar(255) NOT NULL,
    `lag` varchar(255) NOT NULL,
    `long` varchar(255) NOT NULL,
    `created_at` datetime default NOW(),
    PRIMARY KEY (`StationID`)
);

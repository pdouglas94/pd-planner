/*
Navicat MySQL Data Transfer

Source Server         : organizer
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : organizer

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-08-29 20:14:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `updated` int(11) unsigned DEFAULT NULL COMMENT 'timestamp',
  `created` int(11) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `userId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for item
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `categoryId` int(11) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `complete` tinyint(2) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `progress` int(5) DEFAULT NULL,
  `updated` int(11) unsigned DEFAULT NULL COMMENT 'timestamp',
  `created` int(11) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`),
  CONSTRAINT `categoryId` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for subitem
-- ----------------------------
DROP TABLE IF EXISTS `subitem`;
CREATE TABLE `subitem` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `itemId` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `updated` int(11) unsigned DEFAULT NULL COMMENT 'timestamp',
  `created` int(11) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `itemId` (`itemId`),
  CONSTRAINT `itemId` FOREIGN KEY (`itemId`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT '1',
  `username` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `updated` int(11) unsigned DEFAULT NULL COMMENT 'timestamp',
  `created` int(11) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

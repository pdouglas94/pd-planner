
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`userId` INTEGER NOT NULL,
	`name` VARCHAR(250) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `userId` (`userId`),
	CONSTRAINT `userId`
		FOREIGN KEY (`userId`)
		REFERENCES `user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`categoryId` INTEGER NOT NULL,
	`complete` TINYINT(2) NOT NULL,
	`description` TEXT,
	`priority` INTEGER NOT NULL,
	`progress` INTEGER(5) NOT NULL,
	`name` VARCHAR(250) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `categoryId` (`categoryId`),
	CONSTRAINT `categoryId`
		FOREIGN KEY (`categoryId`)
		REFERENCES `category` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`type` INTEGER NOT NULL,
	`username` VARCHAR(50) NOT NULL,
	`email` VARCHAR(50) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`image` VARCHAR(100),
	`created` DATETIME NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `username` (`username`(50), `email`(50))
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

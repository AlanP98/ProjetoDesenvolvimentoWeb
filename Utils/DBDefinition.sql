CREATE DATABASE  IF NOT EXISTS `projeto_desenvolvimento_web` DEFAULT CHARACTER SET utf8;

CREATE TABLE `projeto_desenvolvimento_web`.`person` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`recordNumber` INT(11) NOT NULL,
	`name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
	`gender` CHAR(1) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `recordNumber_UNIQUE` (`recordNumber` ASC)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE `projeto_desenvolvimento_web`.`product` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`recordNumber` INT(11) NOT NULL,
	`description` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `recordNumber_UNIQUE` (`recordNumber` ASC)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8;
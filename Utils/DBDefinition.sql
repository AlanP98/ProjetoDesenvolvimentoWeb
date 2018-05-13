CREATE DATABASE  IF NOT EXISTS `projeto_desenvolvimento_web` DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `projeto_desenvolvimento_web`.`person` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`recordNumber` INT(11) NOT NULL,
	`name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
	`gender` CHAR(1) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `recordNumber_UNIQUE` (`recordNumber` ASC)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `projeto_desenvolvimento_web`.`product` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`recordNumber` INT(11) NOT NULL,
	`description` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `recordNumber_UNIQUE` (`recordNumber` ASC)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `projeto_desenvolvimento_web`.`user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`userName` VARCHAR(45) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `userName_UNIQUE` (`userName` ASC)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8;


# Atualização: 10/05/2018
ALTER TABLE `projeto_desenvolvimento_web`.`person` ADD COLUMN `email` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL AFTER `gender`;
ALTER TABLE `projeto_desenvolvimento_web`.`person` CHANGE COLUMN `gender` `gender` CHAR(1) NOT NULL DEFAULT 'O';

# Atualização: 11/05/2018
ALTER TABLE `projeto_desenvolvimento_web`.`user` ADD COLUMN `accessLevel` INT(2) NOT NULL DEFAULT 0 AFTER `name`;
ALTER TABLE `projeto_desenvolvimento_web`.`user` DROP COLUMN `name`;
ALTER TABLE `projeto_desenvolvimento_web`.`person` ADD COLUMN `idUser` INT(11) NULL AFTER `email`, ADD INDEX `person_user_idx` (`idUser` ASC);
ALTER TABLE `projeto_desenvolvimento_web`.`person` ADD CONSTRAINT `person_user` FOREIGN KEY (`idUser`) REFERENCES `projeto_desenvolvimento_web`.`user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
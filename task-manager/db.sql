-- MySQL Script generated by MySQL Workbench
-- Thu Jan  9 14:35:45 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema task
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema task
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `task` DEFAULT CHARACTER SET utf8 ;
USE `task` ;

-- -----------------------------------------------------
-- Table `task`.`admins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task`.`admins` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `task`.`tasks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task`.`tasks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `email` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `text` TEXT NOT NULL,
  `status` TINYINT NOT NULL DEFAULT 0,
  `edited_by_admin` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = MyISAM;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
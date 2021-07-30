-- -----------------------------------------------------
-- Schema url_shortener
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `url_shortener` DEFAULT CHARACTER SET utf8;
USE `url_shortener`;

-- -----------------------------------------------------
-- Table `url_shortener`.`urls`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `url_shortener`.`urls`
(
    `id`           BIGINT UNSIGNED                                                NOT NULL AUTO_INCREMENT,
    `url`          VARCHAR(2083) CHARACTER SET 'ascii' COLLATE 'ascii_general_ci' NOT NULL,
    `hits`         INT UNSIGNED                                                   NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
    ENGINE = InnoDB;

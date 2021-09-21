CREATE DATABASE internship_system;

CREATE TABLE `internship_system`.`groups` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

CREATE TABLE `internship_system`.`mentors` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL ,
    `group_id` BIGINT UNSIGNED NOT NULL ,
    FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

CREATE TABLE `internship_system`.`interns` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL ,
    `group_id` BIGINT UNSIGNED NOT NULL ,
    FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;
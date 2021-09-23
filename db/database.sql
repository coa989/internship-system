CREATE DATABASE internship_system;

CREATE TABLE `internship_system`.`groups` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

CREATE TABLE `internship_system`.`mentors` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `first_name` VARCHAR(255) NOT NULL ,
    `last_name` VARCHAR(255) NOT NULL ,
    `email` VARCHAR(255) NOT NULL,
    `group_id` BIGINT UNSIGNED NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

CREATE TABLE `internship_system`.`interns` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `first_name` VARCHAR(255) NOT NULL ,
    `last_name` VARCHAR(255) NOT NULL ,
    `email` VARCHAR(255) NOT NULL,
    `group_id` BIGINT UNSIGNED NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;
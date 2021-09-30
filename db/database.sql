CREATE DATABASE your_db_name;

CREATE TABLE `your_db_name`.`groups` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

CREATE TABLE `your_db_name`.`mentors` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `first_name` VARCHAR(255) NOT NULL ,
    `last_name` VARCHAR(255) NOT NULL ,
    `email` VARCHAR(255) NOT NULL,
    `group_id` BIGINT UNSIGNED ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
    FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
    ON DELETE SET NULL ,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

CREATE TABLE `your_db_name`.`interns` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `first_name` VARCHAR(255) NOT NULL ,
    `last_name` VARCHAR(255) NOT NULL ,
    `email` VARCHAR(255) NOT NULL,
    `group_id` BIGINT UNSIGNED ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
    FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
    ON DELETE SET NULL ,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

CREATE TABLE `your_db_name`.`comments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `body` TEXT NOT NULL ,
    `mentor_id` BIGINT UNSIGNED NOT NULL ,
    `intern_id` BIGINT UNSIGNED NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
    FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`)
    ON DELETE CASCADE ,
    FOREIGN KEY (`intern_id`) REFERENCES `interns` (`id`)
    ON DELETE CASCADE ,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;
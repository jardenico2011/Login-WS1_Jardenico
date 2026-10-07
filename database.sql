--  application database
-- Import this file in phpMyAdmin using the Import tab.

CREATE DATABASE IF NOT EXISTS `announcement_management`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `announcement_management`;

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'teacher', 'student', 'member') NOT NULL DEFAULT 'student',
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `announcements` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `category` ENUM('General', 'Event', 'Important') NOT NULL DEFAULT 'General',
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Run safely on an existing installation to enable the Teacher and Student roles.
ALTER TABLE `users`
    MODIFY `role` ENUM('admin', 'teacher', 'student', 'member') NOT NULL DEFAULT 'student';

INSERT INTO `announcements` (`title`, `category`, `message`)
SELECT 'Welcome', 'General', 'Announcements and notices will be posted on this page.'
WHERE NOT EXISTS (SELECT 1 FROM `announcements`);

INSERT INTO `announcements` (`title`, `category`, `message`)
SELECT 'Community Meeting', 'Event', 'Everyone is invited to join the monthly community meeting at 2:00 PM.'
WHERE NOT EXISTS (
    SELECT 1 FROM `announcements` WHERE `title` = 'Community Meeting'
);

INSERT INTO `announcements` (`title`, `category`, `message`)
SELECT 'Update your profile', 'Important', 'Please make sure that your contact information is complete and up to date.'
WHERE NOT EXISTS (
    SELECT 1 FROM `announcements` WHERE `title` = 'Update your profile'
);

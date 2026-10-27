-- =====================================================================
-- A2A Admin Panel - security update (run AFTER adminpanel_setup_local.sql)
-- Run this whole file once in phpMyAdmin / Adminer. Safe to run again:
-- every step checks first. It does NOT change or delete scholarship data.
--
--   1. iccr_admin_login_attempts : every Admin Panel sign-in try (for the
--                                  5-tries / 15-minute lockout and the log)
--   2. iccr_admin_trash          : soft delete (Trash) for students, logins,
--                                  Missions and universities, with restore
--   3. iccr_notifications        : two new columns for the
--                                  draft -> preview -> publish step
-- =====================================================================

-- ---------------------------------------------------------------------
-- 1. Sign-in attempts
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `iccr_admin_login_attempts` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`       VARCHAR(150) NOT NULL DEFAULT '',
  `ip_address`  VARCHAR(45)  NOT NULL DEFAULT '',
  `user_id`     INT NULL DEFAULT NULL,
  `success`     TINYINT(1)   NOT NULL DEFAULT 0,
  `reason`      VARCHAR(40)  NOT NULL DEFAULT '' COMMENT 'ok / password / captcha / locked / unknown_or_not_admin / bad_input',
  `user_agent`  VARCHAR(255) NOT NULL DEFAULT '',
  `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_attempt_email` (`email`, `created_at`),
  KEY `idx_attempt_ip` (`ip_address`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------
-- 2. Trash (soft delete)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `iccr_admin_trash` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_name`    VARCHAR(80)  NOT NULL,
  `record_id`     VARCHAR(80)  NOT NULL,
  `label`         VARCHAR(255) NOT NULL DEFAULT '',
  `prev_status`   VARCHAR(20)  NULL DEFAULT NULL COMMENT 'status before delete, put back on restore',
  `reason`        VARCHAR(255) NOT NULL DEFAULT '',
  `deleted_by`    INT NOT NULL,
  `deleted_email` VARCHAR(150) NOT NULL DEFAULT '',
  `deleted_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `restored_at`   DATETIME NULL DEFAULT NULL,
  `restored_by`   INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_trash_record` (`table_name`, `record_id`, `restored_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------
-- 3. Announcements: draft -> preview -> publish
--    published_at NULL + status 0  = draft (never published)
--    published_at set  + status 0  = taken off the home page
-- ---------------------------------------------------------------------
ALTER TABLE `iccr_notifications` ADD COLUMN IF NOT EXISTS `published_at` DATETIME NULL DEFAULT NULL;
ALTER TABLE `iccr_notifications` ADD COLUMN IF NOT EXISTS `published_by` INT NULL DEFAULT NULL;

-- Announcements that are already showing count as published
UPDATE `iccr_notifications`
SET `published_at` = NOW()
WHERE `published_at` IS NULL AND (`status` IS NULL OR `status` <> '0');

-- Checks:
-- SHOW TABLES LIKE 'iccr_admin_%';
-- SELECT id, title, status, published_at FROM iccr_notifications ORDER BY id DESC LIMIT 10;

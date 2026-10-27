-- =====================================================================
-- A2A Admin Panel - one-time setup (LOCAL XAMPP DATABASE ONLY)
-- Run this whole file once in phpMyAdmin / Adminer on your LOCAL copy of
-- iccr_db_new. It is safe to run again: every step checks first.
--
-- It does three things:
--   1. Creates iccr_nav_links      (header menu, with parent/child hierarchy)
--   2. Creates iccr_admin_audit_log (who changed what, old value, new value)
--   3. Seeds the current header menu and ONE local Super Admin account
--
-- DO NOT run section 3b on the live server. The seed admin is for local
-- testing. Change its password from the panel (Accounts) after first login.
-- =====================================================================

-- ---------------------------------------------------------------------
-- 1. Header navigation links
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `iccr_nav_links` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id`   INT UNSIGNED NULL DEFAULT NULL COMMENT 'NULL = top level',
  `title`       VARCHAR(150) NOT NULL,
  `subtitle`    VARCHAR(150) NOT NULL DEFAULT '' COMMENT 'Small grey text under a dropdown item',
  `url`         VARCHAR(500) NOT NULL DEFAULT '' COMMENT 'Relative (home/cities), absolute (https://...), "#" for a dropdown, or {dashboard}',
  `icon`        VARCHAR(60)  NOT NULL DEFAULT '' COMMENT 'Font Awesome 4 class, e.g. fa-file-pdf-o',
  `position`    ENUM('main','action') NOT NULL DEFAULT 'main' COMMENT 'main = menu, action = button on the right',
  `visibility`  ENUM('all','guest','user') NOT NULL DEFAULT 'all' COMMENT 'guest = logged out only, user = logged in only',
  `page_group`  INT NULL DEFAULT NULL COMMENT 'If set, children are also loaded from iccr_page.master_page_id',
  `new_tab`     TINYINT(1) NOT NULL DEFAULT 0,
  `sort_order`  INT NOT NULL DEFAULT 0,
  `is_active`   TINYINT(1) NOT NULL DEFAULT 1,
  `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_nav_parent` (`parent_id`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------
-- 2. Audit log for every change made through the admin panel
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `iccr_admin_audit_log` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id`    INT NOT NULL,
  `admin_email` VARCHAR(150) NOT NULL DEFAULT '',
  `action`      VARCHAR(20)  NOT NULL COMMENT 'insert / update / status / delete / password',
  `table_name`  VARCHAR(80)  NOT NULL,
  `record_id`   VARCHAR(80)  NOT NULL,
  `column_name` VARCHAR(80)  NOT NULL DEFAULT '',
  `old_value`   MEDIUMTEXT NULL,
  `new_value`   MEDIUMTEXT NULL,
  `note`        VARCHAR(255) NOT NULL DEFAULT '',
  `ip_address`  VARCHAR(45)  NOT NULL DEFAULT '',
  `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_audit_record` (`table_name`, `record_id`),
  KEY `idx_audit_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------
-- 3a. Seed the header menu with what the site shows today
--     (only when the table is still empty)
-- ---------------------------------------------------------------------
INSERT INTO `iccr_nav_links` (`id`,`parent_id`,`title`,`subtitle`,`url`,`icon`,`position`,`visibility`,`page_group`,`new_tab`,`sort_order`)
SELECT * FROM (
  SELECT 1  AS id, NULL AS parent_id, 'Home' AS title, '' AS subtitle, '' AS url, '' AS icon, 'main' AS position, 'guest' AS visibility, NULL AS page_group, 0 AS new_tab, 10 AS sort_order UNION ALL
  SELECT 2,  NULL, 'Home',               '', '{dashboard}', '', 'main', 'user',  NULL, 0, 11 UNION ALL
  SELECT 3,  NULL, 'About Us',           '', '#', '', 'main', 'guest', 1,    0, 20 UNION ALL
  SELECT 4,  NULL, 'Schemes',            '', '#', '', 'main', 'guest', NULL, 0, 30 UNION ALL
  SELECT 5,  4,    'Scheme List',        '', 'home/getAllSchemeList', 'fa-list-ul', 'main', 'all', NULL, 0, 10 UNION ALL
  SELECT 6,  NULL, 'Instructions',       '', '#', '', 'main', 'guest', 3,    0, 40 UNION ALL
  SELECT 7,  NULL, 'Cities Brief',       '', 'home/cities', '', 'main', 'guest', NULL, 0, 50 UNION ALL
  SELECT 8,  NULL, 'Universities',       '', '#', '', 'main', 'guest', NULL, 0, 60 UNION ALL
  SELECT 9,  8,    'Universities',       'PDF, opens in a new tab', 'assets/site/docs/universities.pdf', 'fa-file-pdf-o', 'main', 'all', NULL, 1, 10 UNION ALL
  SELECT 10, 8,    'Universities Details','Excel file', 'assets/site/docs/Universities_Details.xlsx', 'fa-file-excel-o', 'main', 'all', NULL, 1, 20 UNION ALL
  SELECT 11, NULL, 'Guidelines',         '', '#', '', 'main', 'all',   NULL, 0, 70 UNION ALL
  SELECT 12, 11,   'Scholarship Guidelines (Before Filling Form)', 'PDF, 35.1 KB', 'assets/site/docs/Policy_Guidelines.pdf', 'fa-file-pdf-o', 'main', 'all', NULL, 1, 10 UNION ALL
  SELECT 13, 11,   'Physical Fitness Format', 'PDF, 234 KB', 'assets/site/docs/Fitness.pdf', 'fa-file-pdf-o', 'main', 'all', NULL, 1, 20 UNION ALL
  SELECT 14, 11,   'Timeline (2026-2027)', 'PDF, 234 KB', 'assets/site/docs/Timeline-AY-2026-27.pdf', 'fa-calendar', 'main', 'all', NULL, 1, 30 UNION ALL
  SELECT 15, NULL, 'FAQs',               '', '#', '', 'main', 'all',   4,    0, 80 UNION ALL
  SELECT 16, NULL, 'Contact Us',         '', 'home/contactus', '', 'main', 'all', NULL, 0, 90 UNION ALL
  SELECT 17, NULL, 'Alumni',             '', 'http://a2ascholarships.iccr.gov.in/alumni_app', 'fa-graduation-cap', 'action', 'all', NULL, 0, 10
) seed
WHERE NOT EXISTS (SELECT 1 FROM `iccr_nav_links`);

-- ---------------------------------------------------------------------
-- 3b. LOCAL seed Super Admin (user_type 5)
--     Email: ADMIN_EMAIL_HERE
--     The password is stored the same way the portal stores every login:
--     SHA-1 of the plain password (the login page then salts it in the
--     browser). The plain password is NOT written in this file.
--     Uses the same column list as User_model::insertUser, so it works
--     with the existing iccr_users table. Skipped if the email exists.
-- ---------------------------------------------------------------------
INSERT INTO `iccr_users`
  (`parent_type`,`username`,`student_mname`,`student_lname`,`email_id`,`password`,`student_title`,`unique_id`,`mobile_no`,
   `user_type`,`status`,`apply_course_type`,`created`,`state`,`student_type`,`user_country`,`passport_file`,`dir`)
SELECT 0,'Rituraj','','Mahapatra','ADMIN_EMAIL_HERE','SHA1_OF_ADMIN_PASSWORD_HERE','','','',
       5,1,0,NOW(),0,0,0,'',''
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `iccr_users` WHERE `email_id` = 'ADMIN_EMAIL_HERE');

-- Check:
-- SELECT id, username, email_id, user_type, status, created FROM iccr_users WHERE email_id = 'ADMIN_EMAIL_HERE';

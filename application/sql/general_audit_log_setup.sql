-- =====================================================================
-- A2A - General audit log (table audit_log)   - safe to run again
-- ---------------------------------------------------------------------
-- The portal-wide "who changed what, when" table, used for the daily
-- report. The Admin Panel writes one row per changed field here (as
-- well as in iccr_admin_audit_log). Database audit triggers, if you
-- install them, write here too; the Admin Panel then skips its own row
-- for that table so nothing is counted twice.
--
-- No IP addresses are stored. Password-type values are saved as [hidden].
--
-- Run in Adminer / phpMyAdmin on the database the portal uses.
-- It only CREATES a new table (if missing). It changes no existing data.
-- =====================================================================

CREATE TABLE IF NOT EXISTS `audit_log` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `changed_at`     DATETIME(3)  NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
  `table_name`     VARCHAR(64)  NOT NULL,
  `record_id`      VARCHAR(64)  NOT NULL,
  `application_id` VARCHAR(50)  NULL,
  `action`         ENUM('INSERT','UPDATE','DELETE') NOT NULL,
  `field_name`     VARCHAR(64)  NULL,
  `old_value`      TEXT NULL,
  `new_value`      TEXT NULL,
  `user_id`        VARCHAR(64)  NOT NULL,
  `user_name`      VARCHAR(100) NOT NULL,
  `user_role`      VARCHAR(50)  NOT NULL,
  `remarks`        VARCHAR(500) NULL,
  PRIMARY KEY (`id`),
  KEY `idx_app`   (`application_id`),
  KEY `idx_date`  (`changed_at`),
  KEY `idx_user`  (`user_id`),
  KEY `idx_table` (`table_name`, `record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Checks (run one at a time):
-- SHOW TABLES LIKE 'audit_log';
-- SELECT changed_at, application_id, table_name, field_name, old_value, new_value, user_name, user_role, remarks FROM audit_log WHERE changed_at >= CURDATE() ORDER BY id DESC;
--
-- Permissions note (live server, optional): the website's DB account needs
-- SELECT and INSERT on audit_log (Admin Panel writes and shows it), but it
-- should NOT have UPDATE or DELETE, so nobody can edit or erase history.

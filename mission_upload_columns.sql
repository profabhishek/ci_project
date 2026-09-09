-- ---------------------------------------------------------------------------
-- A2A Scholarship Portal
-- Adds storage for the two documents the Mission uploads while processing an
-- application: the Medical Fitness Certificate and the Undertaking Form.
--
-- WHY NEW COLUMNS RATHER THAN THE EXISTING ONES
-- iccr_status_mapping already has `medical_fitness` and `undertaking_doc`, but
-- those belong to a LATER stage of the workflow and are written by the
-- applicant, not the Mission:
--
--   * Applicant.php (uploadUndertaking) writes `undertaking_doc` = time() -
--     a UNIX TIMESTAMP, not a filename. Home.php then renders it with
--     date('d-m-Y', ...) in several places.
--   * status_helper.php decides which status the applicant is shown based on
--     whether `undertaking_doc` is NULL.
--   * `medical_fitness` holds the applicant's own certificate, uploaded after
--     the university has confirmed admission.
--
-- Writing the Mission's filenames into those columns would put a filename
-- where date() expects a timestamp, and would make the system believe the
-- applicant had already accepted an offer that has not been made yet. These
-- two new columns keep the Mission's uploads entirely separate, so nothing
-- that exists today changes behaviour.
--
-- Both columns are NULL-able with no default, so every existing row is
-- untouched and no current query is affected.
--
-- Run once, on the production database, before uploading the PHP files.
-- ---------------------------------------------------------------------------

ALTER TABLE `iccr_status_mapping`
    ADD COLUMN `mission_medical_fitness` VARCHAR(255) NULL DEFAULT NULL
        COMMENT 'Filename of the Medical Fitness Certificate uploaded by the Mission at processing time',
    ADD COLUMN `mission_undertaking_form` VARCHAR(255) NULL DEFAULT NULL
        COMMENT 'Filename of the Undertaking Form uploaded by the Mission at processing time';

-- Verification - both columns should be listed, type varchar(255), Null = YES:
-- SHOW COLUMNS FROM `iccr_status_mapping` LIKE 'mission_%';

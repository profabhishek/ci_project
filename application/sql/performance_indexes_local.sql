-- =====================================================================
-- A2A portal - speed-up indexes (run on your LOCAL database first)
--
-- What this does: adds "look-up shortcuts" (indexes) on the columns the
-- portal searches and joins on all the time. Without them MySQL reads the
-- whole table (2 lakh+ rows) on every page load. With them it jumps straight
-- to the rows it needs. No data is changed.
--
-- Safe to run more than once: "IF NOT EXISTS" skips indexes already there.
-- Needs MariaDB (XAMPP uses MariaDB). Each line can take a few seconds on
-- big tables. On the LIVE server, run it outside office hours and take a
-- backup first.
--
-- Before / after check (run before and after, compare the "rows" column):
--   EXPLAIN SELECT id FROM iccr_status_mapping WHERE uid = 517705;
-- =====================================================================

-- Logins and students
CREATE INDEX IF NOT EXISTS idx_a2a_users_type_id     ON iccr_users (user_type, id);
CREATE INDEX IF NOT EXISTS idx_a2a_users_email       ON iccr_users (email_id);
CREATE INDEX IF NOT EXISTS idx_a2a_users_username    ON iccr_users (username);
CREATE INDEX IF NOT EXISTS idx_a2a_users_lname       ON iccr_users (student_lname);
CREATE INDEX IF NOT EXISTS idx_a2a_users_created     ON iccr_users (created);

CREATE INDEX IF NOT EXISTS idx_a2a_sdetails_uid      ON iccr_student_details (uid);
CREATE INDEX IF NOT EXISTS idx_a2a_sdetails_passport ON iccr_student_details (passport_no);

-- Applications and workflow (used by Mission, University, HQ and Regional lists too)
CREATE INDEX IF NOT EXISTS idx_a2a_sm_uid            ON iccr_status_mapping (uid);
CREATE INDEX IF NOT EXISTS idx_a2a_sm_appno          ON iccr_status_mapping (application_no);
CREATE INDEX IF NOT EXISTS idx_a2a_sm_created        ON iccr_status_mapping (created);
CREATE INDEX IF NOT EXISTS idx_a2a_appdet_appno      ON iccr_student_application_details (application_no);
CREATE INDEX IF NOT EXISTS idx_a2a_other_appno       ON iccr_student_other_details (application_no);
CREATE INDEX IF NOT EXISTS idx_a2a_other_through     ON iccr_student_other_details (application_through);
CREATE INDEX IF NOT EXISTS idx_a2a_uresp_appid       ON iccr_university_response (application_id);

-- Home page announcements
CREATE INDEX IF NOT EXISTS idx_a2a_notif_upto        ON iccr_notifications (validated_upto);

-- Refresh table statistics so MySQL picks the new indexes
ANALYZE TABLE iccr_users, iccr_student_details, iccr_status_mapping, iccr_student_application_details,
              iccr_student_other_details, iccr_university_response, iccr_notifications;

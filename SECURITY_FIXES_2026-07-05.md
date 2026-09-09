# Security & Performance Fixes — 5 July 2026

## What was changed

### 1. SQL injection (fixed)
- `Admin_model.php`, `Common_model.php`: every string-concatenated `where()` using
  `$this->input->post('Region')` / `post('Universtiy')` now casts to `(int)` (14 live spots).
- All concatenated numeric function args (`$regionId`, `$missionId`, `$universityId`,
  `$uniId`, `$toyear`, `$fromyear`, `$quarter`) are also `(int)`-cast (~80 spots).
- String financial-year params (`$fy`, `$Fy`) in raw SQL are sanitized with
  `preg_replace('/[^0-9\-]/', '', ...)` — values like `2022-23` pass through unchanged.
- Bonus: `models/admin/common_model.php` keyword search now uses `escape_like_str()`.

### 2. File uploads (locked down)
- New helper `application/helpers/upload_security_helper.php` (autoloaded):
  `iccr_safe_move_upload()` — extension whitelist (`jpg|jpeg|png|gif|pdf|doc|docx`),
  real MIME check via `finfo`, path-traversal block, and it auto-writes a
  no-script-execution `.htaccess` into any folder it uploads to (covers the
  runtime-created `<year>/applications_doc/...` folders).
- All 35 raw `move_uploaded_file()` calls in `Applicant.php` now go through it.
  On rejection it returns FALSE, so the existing "Error While Uploading File"
  branches handle it — no flow changes.
- `.htaccess` (deny script execution) added to the existing upload folders under `assets/`.

### 3. Config hardening
- `index.php`: `ENVIRONMENT` now auto-detects — `development` on localhost,
  `production` everywhere else. Override with the `CI_ENV` server variable.
- `config.php`: new random `encryption_key`, overridable via env var `CI_ENCRYPTION_KEY`.
  (Safe to rotate: `encrypt->encode/decode` is never called anywhere in the app.)
- `database.php`: credentials read env vars `CI_DB_HOST`, `CI_DB_USER`, `CI_DB_PASS`,
  `CI_DB_NAME`, falling back to the current local values. Set these on the live server.
- `application/.htaccess`: deny rules were commented out — re-enabled.
- `global_xss_filtering` left FALSE **intentionally**: it mutates all input and would
  corrupt CKEditor HTML content saved from admin pages. Output escaping is used instead (#4).
  CSRF protection and httponly cookies were already enabled.

### 4. XSS on output
- All 18 `echo $_GET['appno']` spots in views wrapped in `html_escape()`.
- `viewAgencyExpenditureDetailsofStudent.php`: POST-derived `$fy`/`$rg`/`$sc` escaped.
- Two `form_open(...$_GET['appno'])` concatenations escaped.

### 5. Performance
- mPDF / PHPExcel / zip / fpdi removed from the constructors of `Applicant`,
  `Headquarter`, `Admin`, `University` and loaded only inside the ~39 methods that
  actually use them (Mission/Regional already followed this pattern).
- Fixed `Admin::download_zip()` — it used `$this->zip` without ever loading the library
  (was fatally broken).

### 6. Cleanup
- Moved to `_archive/` (denied to web clients via `.htaccess`): `Headquarter_bckp_*`,
  `Blogdemo.php`, `Userdemo.php`, `User - Copy.php`, `*.php_06_04_2023`,
  `User.php_03/05_04_2023`, `User_model_old.php`, `User_modelassas.php`,
  `views/errors.zip`, `views/uplaod.zip`, `views/uplaod/`, `assets/site/main/css/test.php`.
- Removed live debug output that was corrupting real pages:
  - `Applicant.php` — `print_r` inside the university dropdown AJAX (garbled options)
  - `Headquarter.php` — `print_r(...);die()` that killed the documents-zip download
  - `Page.php` — two `print_r(...);exit;` in slug-check callbacks
  - `Regionallive.php` — `print_r(...);die;` in a DataTables endpoint
  - `models/admin/common_model.php` — SQL echoed into admin output
  (The ~787 commented-out debug lines were left as comments — they never execute.)

## Pre-existing broken files repaired (not caused by these fixes)
Three files in the working copy were truncated mid-statement and one had stray braces —
i.e. the app could not have run at all in this state. Restored from git history,
preserving all uncommitted improvements:
- `application/models/Common_model.php` — truncated at line 12179; tail restored from HEAD
- `application/controllers/Mission.php` — truncated at line 5657; tail restored from HEAD
- `application/config/autoload.php` — truncated final line restored
- `application/controllers/University.php` — 4 duplicated `}` removed (parse error)

## Still recommended (needs staging tests — not done to avoid breakage)
1. **`SELECT *` → explicit columns** and **N+1 loops** in list/report models: real wins,
   but every view's column usage must be tested. Do per-report on staging.
2. Raw `move_uploaded_file` in `Admin`, `Headquarter`, `Mission`, `Regional`, `Sfs`,
   `University`, `Home`, `Page` controllers: switch them to `iccr_safe_move_upload()`
   too — check each flow's allowed types first (some accept Excel).
3. `Regional_model.php` / `Reports.php` also concatenate `$fy`/`$regionid` into SQL
   (admin-authenticated paths). Apply the same casting/sanitizing pattern.
4. **Enable opcache** on the live server (php.ini): `opcache.enable=1`,
   `opcache.memory_consumption=192`, `opcache.max_accelerated_files=20000`.
5. Third-party libs `mpdf60`, `PHPExcel` use PHP-7-only syntax (`$str{$i}`) —
   fine today, but they block any future PHP 8 upgrade.
6. `ckeditor/config.js` points kcfinder at a hardcoded old IP (`205.147.98.190/a2a`) —
   likely dead; kcfinder's own `upload.php` is a known attack surface. If the admin
   file-browser isn't used, remove `assets/site/main/js/kcfinder/`.
7. Set `CI_DB_PASS` etc. on the live server and remove real credentials from git history.

# A2A Scholarship Portal — Technical Assessment

**Purpose:** an evidence-based assessment of the current application, to support the decision on whether to continue patching it or rebuild it.

**Date:** August 2026
**Scope examined:** `application/` — 17 controllers, 8 models, 529 view files, ~101,000 lines of application code (excluding bundled third-party libraries).

**How to read this document:** every claim below has (a) a plain-English explanation, (b) a number, and (c) a command or URL that reproduces it. Nothing here is opinion. If a point can't be reproduced, it should be struck out.

---

## Summary for non-technical readers

Think of this application as a building. The concerns below are not "the paint is peeling" — those would be worth fixing. They are closer to: the building is on a foundation the manufacturer stopped supporting ten years ago, the front door lock can be opened by anyone who knows the trick, and there are two nearly identical copies of the third floor where staff sometimes renovate the wrong one.

Individually, several of these are fixable. The argument for rebuilding is not that any single item is fatal. It is that **the cost of fixing them all, safely, on a live system with no tests, approaches the cost of building it properly — and leaves you with a ten-year-old foundation at the end.**

---

## 1. The foundation is ten years old and no longer receives security fixes

**Plain English:** The framework the site is built on is a version released in July 2016. Even within that old generation, thirteen further updates were published — including security fixes — and none were applied. The generation itself last received any update in March 2022.

**Evidence:**

| Item | Value |
|---|---|
| Installed version | CodeIgniter **3.1.0** |
| Release date of installed version | **26 July 2016** (10 years ago) |
| Last release in that generation | 3.1.13, March 2022 |
| Security/bugfix releases missed | **13** |

**Verify it yourself:**
```
grep CI_VERSION system/core/CodeIgniter.php
```
Compare against the public release list: <https://versionlog.com/codeigniter/3/>

**Why this can't simply be "patched":** upgrading to the current generation (CodeIgniter 4) is not an update — it is a different framework with a different structure. The vendor's own migration guidance amounts to rewriting the application layer. So "upgrade the framework" and "rebuild the application" are largely the same project.

---

## 2. The site is open to database attacks in 42 places

**Plain English:** In 42 places, values typed by a user are pasted directly into database commands without being cleaned first. This is the single most well-known category of web vulnerability (SQL injection). It can allow an attacker to read, alter, or destroy data they should never see — in this case, scholarship applicants' passport numbers, contact details and documents.

**Evidence:** 42 occurrences, all in the data layer.

**Verify it yourself:**
```
grep -rnE '\->(where|or_where|having|join|order_by)\(.*\.\s*\$(vars|_POST|_GET)\[' application/models/*.php | wc -l
```

**A concrete example** — `application/models/Hqrs_model.php`, line 115:
```php
$this->db->where(' (iccr_student_application_details.course=' . $vars['Counrse'] . ' or ...');
```
`$vars['Counrse']` arrives directly from the browser. The framework provides a safe way to do this (`$this->db->where('col', $value)`, which escapes automatically). It was not used here.

> ⚠️ **Please do not test this by attacking the live site.** It is verifiable by reading the code. Any actual testing should be done by your own team on a copy, with authorisation.

**Is this fixable without a rewrite?** Yes — these 42 sites could be corrected. It is listed here because it demonstrates the *standard of care* applied throughout, not because it alone justifies rebuilding.

---

## 3. Security protection has been switched off for 237 URLs

**Plain English:** The framework includes a protection that stops other websites from silently performing actions as a logged-in user (CSRF protection). Rather than making the site work correctly with that protection, it has been disabled for 237 individual addresses — including approval and status-change actions.

**Evidence:** 237 entries in the exclusion list.

**Verify it yourself:** open `application/config/config.php` and look at `$config['csrf_exclude_uris']` — a single list containing 237 URLs.

---

## 4. Whole sections of the system exist in duplicate, and they have drifted apart

**Plain English:** There are two near-identical copies of the Regional Office module, and two of the Mission module. They are 87% identical. When a bug is fixed, it must be remembered and fixed in both. When it isn't, the two copies behave differently — and no one can tell which is correct.

**Evidence:**

| File | Lines |
|---|---|
| `Regional.php` | 15,643 |
| `Regionallive.php` | 14,283 |
| Lines that differ between them | 2,028 (**≈87% identical**) |

Also present: `Mission.php` / `Missionlive.php`.

**Verify it yourself:**
```
diff <(sed 's/[[:space:]]//g' application/controllers/Regional.php) \
     <(sed 's/[[:space:]]//g' application/controllers/Regionallive.php) | grep -c '^[<>]'
```

**The same problem in miniature:** the scholarship offer letter is written out five separate times, once in each of five controllers (`Applicant`, `Headquarter`, `Mission`, `Regional`, `University`). A wording change requires five edits.

```
grep -l "provisionally selected to pursue Nomenclature" application/controllers/*.php
```

**This is exactly how the blank-letter bug happened.** In the University copy, the variable holding the course name was never filled in, so the letter printed `Nomenclature ""`. The Headquarter copy of the same letter, reading the same database record, printed `MA SOCIAL WORK` correctly. Same data, two copies of the code, two different outputs.

---

## 5. There are no automated tests — so no change can be made safely

**Plain English:** There is no way to check whether a change has broken something, other than a person clicking through the site and noticing. On a system of this size, that is not realistic. This is why fixes here tend to reveal new failures elsewhere.

**Evidence:** no test suite of any kind exists.

**Verify it yourself:**
```
ls phpunit.xml tests/ 2>/dev/null   # returns nothing
```

**Why this matters more than it sounds:** it is the reason the other items are expensive rather than cheap to fix. Correcting 42 database calls is a day's work. Proving you haven't broken the scholarship workflow while doing it, without tests, is weeks.

---

## 6. Five different PDF engines are bundled, for one job

**Plain English:** The system carries five separate libraries that all do the same thing — produce PDF documents — plus an obsolete copy of one of them. Each is a separate thing to maintain and secure.

**Evidence:** `TCPDF`, `fpdf`, `fpdi`, `mpdf60`, `dompdf` (plus `dompdf-old`), `csspdf`.

**Verify it yourself:**
```
ls -d application/libraries/*/
```

**This is not theoretical.** One of these engines (`mpdf60`) is installed with an incomplete font set — 22 of the 42 fonts its own configuration declares are missing from disk. Any document that uses a serif or monospace font causes it to abort. This made bulk PDF generation impossible until the code was moved to a different engine.

```
ls application/libraries/mpdf60/ttfonts/ | grep -i serif    # DejaVu Serif absent
```

---

## 7. Business rules are hard-coded and must be hand-edited every year

**Plain English:** Which applications belong to which academic year is decided by raw numeric timestamps written into the code in 46 places. Every year, a developer must edit these by hand. If one is missed or mistyped, applications silently disappear from staff screens.

**Evidence:** 46 hard-coded year boundaries.

**Verify it yourself:**
```
grep -c "iccr_status_mapping.created >=" application/models/Hqrs_model.php
```

**This has already happened.** The 2026 boundary was set to 27 February 2026 instead of 1 January 2026. Every application submitted in the first eight weeks of 2026 was invisible to Headquarters staff — not deleted, just missing from the list, with no error shown.

---

## 8. Misspellings are baked into the database and cannot be corrected cheaply

**Plain English:** Several database column names are misspelled. Because hundreds of files refer to them, correcting the spelling would mean changing the database and every file at once. So the misspellings persist and get copied into every new piece of work — including the public API.

**Evidence:**

| Misspelling | Intended | Files affected |
|---|---|---|
| `universty_choice` | university_choice | **134** |
| `gardiuan_address_city` | guardian_address_city | 47 |
| `Counrse` | Course | 45 |
| `acedemic_year` | academic_year | 14 |

**Verify it yourself:**
```
grep -rl "universty_choice" application/ | wc -l
```

**Why it matters beyond tidiness:** these names appear in the data shared with partner organisations. External systems have been built against the misspellings, which means they are now effectively permanent.

---

## 9. Failures are silent — the system hides its own errors

**Plain English:** In many places the code assumes a database query succeeded. When it doesn't, the page returns nothing at all, and the user sees an unexplained error or an empty screen. The actual cause is discarded.

**Concrete example already encountered:** the Headquarters "New Applications" screen showed `DataTables warning: Invalid JSON response`. The real cause was a failed query whose error was never recorded. Staff had no way to know whether the list was empty because there were no applications, or because the system was broken.

**A second example:** `getApplicationStepThreebyAppNo()` filtered on a variable that was never defined, so it always returned nothing. Every screen calling it silently showed blank sections. It had been that way long enough that no one questioned it.

---

## 10. The pages themselves are structurally invalid

**Plain English:** The HTML the system produces is malformed — table cells outside of rows, blocks of content inside tables, a main table left unclosed across entire sections. Web browsers silently repair this, which is why the site *looks* fine. Anything that is not a browser — a PDF generator, a screen reader, an accessibility checker, a government compliance audit — does not.

**Evidence:** 14 structural violations on a single application page.

**Verify it yourself:** open any application page and run it through the W3C validator: <https://validator.w3.org/>

**This is not cosmetic.** It is the reason generating a PDF of the application form was impossible: the PDF engine encountered a table cell with no parent table and aborted every time. For a public-sector portal, invalid markup also carries accessibility-compliance exposure.

---

## 11. Track record: defects found per unit of work

**Plain English:** The clearest evidence of overall condition is how many pre-existing defects surface during ordinary work. During three small feature requests, the following *pre-existing* faults were found — none of which were what we set out to do:

1. Two different university names shown for the same applicant on one screen
2. Applications from Jan–Feb 2026 invisible to Headquarters (hard-coded year boundary)
3. A column in the applications table that no code ever populates (`final_course`)
4. A file-download function that could be used to read any file on the server
5. Applicant name search crashing on a database character-set mismatch
6. A lookup that always returned empty because of an undefined variable
7. A screen breaking because a table column was missing from the data
8. The University offer letter printing a blank course name
9. PDF generation impossible due to an incomplete font installation
10. Invalid page markup preventing document generation entirely

**This is the key number:** ten unrelated, pre-existing defects, in three small pieces of work, in different modules. That rate is not consistent with a system that needs targeted repair. It is consistent with one where the same standard of care was applied throughout.

---

## What an honest counter-argument looks like

A rewrite should not be argued for dishonestly. In fairness:

- **Rewrites carry real risk.** Large rewrites frequently overrun and can reintroduce bugs that were long since fixed in the old system. This is a genuine, well-documented risk.
- **Several items above are individually fixable.** The 42 injection points, the 237 CSRF exclusions and the duplicate controllers could each be remediated in place.
- **The system does work.** It is processing thousands of live applications today. That has value and should not be dismissed.

**Why the conclusion still holds:** the decisive factors are items **1** (the foundation is unsupported, and moving off it is itself a rewrite), **5** (no tests, so every in-place fix is unverifiable and risky), and **11** (defect density indicating systemic rather than local problems). Fixing items 2–10 individually would consume most of the effort of a rebuild and still leave the application on a ten-year-old, unsupported foundation with no tests.

Put simply: **you would pay most of the cost of a new system, and still have the old one.**

---

## Recommended framing for the decision

1. **Do not stop maintaining the current system.** It must keep running through at least one full application cycle.
2. **Treat the SQL injection findings as urgent regardless of the decision.** Those 42 points should be remediated now — they are a live risk to applicant data, not a future concern.
3. **Build the replacement alongside, module by module**, starting with the highest-traffic workflow (application intake). This avoids the single largest rewrite risk — the "big bang" cutover.
4. **Require tests in the new system from day one.** The absence of tests is the root cause of why the current system cannot be safely changed.

---

## Verification appendix — every command in one place

Run from the application root:

```bash
# 1. Framework version and age
grep CI_VERSION system/core/CodeIgniter.php

# 2. SQL injection points
grep -rnE '\->(where|or_where|having|join|order_by)\(.*\.\s*\$(vars|_POST|_GET)\[' \
     application/models/*.php | wc -l

# 3. CSRF exclusions
grep -A2 "csrf_exclude_uris" application/config/config.php

# 4. Duplicate controllers
wc -l application/controllers/Regional.php application/controllers/Regionallive.php
grep -l "provisionally selected to pursue Nomenclature" application/controllers/*.php

# 5. Tests
ls phpunit.xml tests/ 2>/dev/null

# 6. PDF engines
ls -d application/libraries/*/

# 7. Hard-coded year boundaries
grep -c "iccr_status_mapping.created >=" application/models/Hqrs_model.php

# 8. Schema misspellings
grep -rl "universty_choice" application/ | wc -l

# 10. Page validity
# paste any application page URL into https://validator.w3.org/
```

---

*Every figure in this document was produced by the commands above against the codebase as of August 2026. If any number cannot be reproduced, that point should be withdrawn.*

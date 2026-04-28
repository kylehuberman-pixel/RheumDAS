---
description: Run a security audit across the RheumDAS codebase — secrets, injection, file handling, redirects.
---

# /security-audit

Run a comprehensive security sweep of the RheumDAS codebase and report findings as a punch list. Don't fix anything — just report.

## Steps

### 1. Hunt for hardcoded secrets

```bash
grep -rnE "(password|api[_-]?key|token|secret|smtp)" --include="*.php" --include="*.js" \
  /home/kyle/Projects/RheumDAS \
  | grep -vE "(libraries/|\.git/|node_modules/)" \
  | grep -iE "['\"=].*['\"]"
```

Also grep for hex-token-shaped strings (32+ hex chars) and base64-shaped strings near assignment operators. Check that anything credential-like is sourced from `config.php`, not literal.

### 2. Confirm `config.php` is gitignored

```bash
cd /home/kyle/Projects/RheumDAS
git check-ignore -v config.php           # should match a .gitignore rule
git ls-files | grep -E "^config\.php$"   # should return NOTHING
```

### 3. Scan PHP for unsanitized user input reaching dangerous sinks

For each of `$_GET`, `$_POST`, `$_REQUEST`, `$_COOKIE`, `$_SERVER`, find usages and trace whether they reach (without filtering/escaping):

- **Output sinks** (XSS): `echo`, `print`, `printf`, interpolated HTML
- **Filesystem sinks** (path traversal, RFI/LFI): `include`, `require`, `file_put_contents`, `fopen`, `unlink`, `file_get_contents`
- **Process sinks** (RCE): `exec`, `system`, `shell_exec`, `passthru`, `popen`, `eval`
- **DB sinks** (SQLi): any string concat into a query — note this codebase doesn't currently use a DB; flag if one is introduced

Use Grep across `*.php` excluding `libraries/`.

### 4. Check the email/file flows specifically

- `HAQ_DI/email.php::createFile($name)` — `$name` is built from `$to` (user input). Confirm sanitization or pin to safe directory.
- `email-image.php` — `$_POST['imgBase64']` is decoded and written to `temp/`. Filename uses `uniqid()` (safe), but verify content-type isn't trusted.
- `save-image.php`, `export-canvas.php`, `folder-clear.php` — read each and assess input handling.

### 5. Review `.htaccess`

- Confirms HTTPS-only redirect is in place (currently does)
- No directory listing exposure
- No exposed PHP source via misconfiguration

### 6. Cross-check `config.example.php`

Ensure it contains only placeholders, not a real token leftover.

## Reporting

Output a punch list grouped by severity:

- **Critical** (block deploy): leaked secrets, RCE, persistent XSS, SQLi
- **High**: reflected XSS, path traversal, missing HTTPS enforcement
- **Medium**: information disclosure (stack traces, file paths in errors), weak validation
- **Low**: defense-in-depth nits (CSP missing, no CSRF on state-changing forms)

For each finding, cite `file.php:line`, paste the offending snippet, and recommend a fix in one sentence. End with a one-line overall verdict.

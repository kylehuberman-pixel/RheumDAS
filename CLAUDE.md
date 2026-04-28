# CLAUDE.md

Notes for Claude Code sessions working in this repository.

## What this is

RheumDAS — a PHP web app for rheumatology care providers. Calculates Disease Activity Scores, includes a HAQ-DI module, exports charts as PNG, generates PDF reports, and emails results to patients. Procedural PHP, no framework, vendored libraries under `libraries/`.

## Stack & key files

- **Entrypoints**: `index.php` (DAS calculator), `about.php`, `HAQ_DI/index.php` (HAQ-DI module)
- **Email path**: `HAQ_DI/email.php` and `email-image.php` → Postmark REST API (`https://api.postmarkapp.com/email/withAttachments`) via `curl`
- **PDF generation**: `HAQ_DI/pdf.php` is the template; rendered by DOMPDF (`libraries/dompdf/autoload.inc.php`) inside `HAQ_DI/email.php::createFile()`
- **JS entrypoints**: `js/HAQ_DI.js`, `js/rheumdas.js`, `js/rheumexport.js`, `js/tooltip.js`
- **Config**: `config.php` (local, gitignored) holds `$POSTMARK_TOKEN`, `$MAIL_FROM`, `$MAIL_FROM_NAME`. `config.example.php` is the committed template.

## Conventions

- Vendored libraries live under `libraries/` (DOMPDF active, PHPMailer present but no longer used). Don't introduce Composer unless there's a real reason.
- **Secrets always go in `config.php`** and are read by `require_once` at the top of any file that needs them. Never hardcode tokens, passwords, or API keys in source files.
- `temp/` and `HAQ_DI/save/` are runtime scratch directories — they ship empty (just `.gitkeep`) and are written by the app at runtime.
- PHP files use procedural style with `function send($to, $body)` patterns, returning associative arrays. Stick with that style for consistency with the existing codebase.

## Don't commit

- `error_log`, `*.log`
- `.ftpquota`
- `temp/*`, `HAQ_DI/save/*` (other than `.gitkeep`)
- `config.php`
- `*.css.map`

`.gitignore` enforces all of the above.

## Local dev

```bash
cp config.example.php config.php   # then edit in real Postmark token
php -S localhost:8000
```

Open <http://localhost:8000> for the DAS calculator or <http://localhost:8000/HAQ_DI/> for the HAQ-DI module.

Postmark requires `$MAIL_FROM` to be a verified Sender Signature on the account, otherwise email sends will return a 422 from the API.

## Agents & slash commands

Local Claude Code tooling lives in `.claude/`:

- **`.claude/agents/php-reviewer.md`** — proactively reviews PHP changes for security and legacy-PHP pitfalls
- **`.claude/agents/frontend-reviewer.md`** — reviews JS/CSS/HTML changes
- **`.claude/commands/security-audit.md`** — `/security-audit` runs a full secret-and-injection sweep
- **`.claude/commands/deploy.md`** — `/deploy` documents the deployment procedure to rheumdas.com

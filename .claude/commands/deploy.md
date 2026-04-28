---
description: Deploy RheumDAS to the rheumdas.com production host.
---

# /deploy

Deploy the current state of RheumDAS to `rheumdas.com`. The host is FTP-based (the project's webroot was previously bootstrapped from an FTP copy — `.ftpquota` artifact in early history). Uses an `lftp` mirror by default; substitute `rsync` if SSH is available instead.

## Pre-deploy checklist

1. **Run the security audit first**: `/security-audit`. Resolve any Critical or High findings before continuing.
2. **Smoke-test locally**:
   ```bash
   cd /home/kyle/Projects/RheumDAS
   php -S localhost:8000
   ```
   - Open <http://localhost:8000> — confirm the DAS calculator loads.
   - Open <http://localhost:8000/HAQ_DI/> — complete a sample assessment, click "Email" and confirm Postmark returns success.
3. **Confirm Postmark sender is verified** for `$MAIL_FROM` in `config.php`.
4. **Confirm `config.php` exists on the server** with the production token. The deploy MUST NOT overwrite it — the server's `config.php` is the source of truth in production.
5. **Confirm `temp/` and `HAQ_DI/save/` exist on the server** and are writable by the web server user (`chmod 0775`).

## Files to upload

Everything except:

- `.git/`
- `.claude/`
- `*.md` (README.md, CLAUDE.md)
- `config.example.php`
- `config.php` (NEVER upload local config — server has its own)
- `*.css.map`
- `*.log`, `error_log`
- `temp/*` (server keeps its own scratch)
- `HAQ_DI/save/*` (server keeps its own scratch)
- `.gitignore`, `.gitkeep`

## Deploy via lftp (FTP)

```bash
cd /home/kyle/Projects/RheumDAS
lftp -e "set ssl:verify-certificate yes; \
  mirror -R \
    --exclude-glob .git/ \
    --exclude-glob .claude/ \
    --exclude-glob '*.md' \
    --exclude-glob 'config.example.php' \
    --exclude-glob 'config.php' \
    --exclude-glob '*.css.map' \
    --exclude-glob '*.log' \
    --exclude-glob 'error_log' \
    --exclude-glob 'temp/*' \
    --exclude-glob 'HAQ_DI/save/*' \
    --exclude-glob '.gitignore' \
    --exclude-glob '.gitkeep' \
    --verbose \
    . /public_html/; \
  bye" \
  -u $FTP_USER,$FTP_PASS ftp.rheumdas.com
```

(Adjust remote path `/public_html/` to match the host's webroot.)

## Deploy via rsync (if SSH available)

```bash
rsync -avz --delete \
  --exclude='.git/' \
  --exclude='.claude/' \
  --exclude='*.md' \
  --exclude='config.example.php' \
  --exclude='config.php' \
  --exclude='*.css.map' \
  --exclude='*.log' \
  --exclude='error_log' \
  --exclude='temp/*' \
  --exclude='HAQ_DI/save/*' \
  --exclude='.gitignore' \
  --exclude='.gitkeep' \
  /home/kyle/Projects/RheumDAS/ \
  user@rheumdas.com:/var/www/rheumdas/
```

## Post-deploy smoke test

1. Open <https://rheumdas.com> — confirm DAS calculator loads.
2. Open <https://rheumdas.com/HAQ_DI/> — run a sample HAQ assessment.
3. Send a test email to yourself; confirm:
   - You receive the PDF/PNG attachment.
   - Postmark dashboard shows the send.
4. Watch `error_log` on the server for any new entries.

## Rollback

If something breaks, redeploy the previous good commit:

```bash
git checkout <previous-good-sha>
# re-run the lftp/rsync command above
git checkout main
```

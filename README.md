# RheumDAS

A web-based Disease Activity Score (DAS) calculator for rheumatology care providers. RheumDAS includes a HAQ-DI (Health Assessment Questionnaire — Disability Index) module, exportable charts, PDF generation, and emailed patient reports.

## Tech stack

- **Backend**: PHP (procedural, no framework)
- **Frontend**: Bootstrap 3, jQuery, html2canvas, canvg, Tooltipster, jQuery UI Slider Pips
- **PDF generation**: [DOMPDF](https://github.com/dompdf/dompdf) (vendored under `libraries/dompdf/`)
- **Transactional email**: [Postmark](https://postmarkapp.com/) (REST API via `curl`)

## Project structure

```
.
├── index.php              # Disease Activity Score calculator (entrypoint)
├── about.php              # About / info page
├── email-image.php        # Emails the DAS chart export as PNG
├── export-canvas.php      # Canvas → image export endpoint
├── save-image.php         # Save canvas image to temp/
├── folder-clear.php       # Clears temp/ on demand
├── HAQ_DI/                # HAQ-DI calculator module
│   ├── index.php
│   ├── question.php
│   ├── actions.php
│   ├── email.php          # Builds PDF, emails via Postmark
│   ├── pdf.php            # PDF template (rendered into DOMPDF)
│   ├── print.php
│   ├── practitioners.php
│   └── save/              # Transient PDF output (gitignored)
├── libraries/             # Vendored PHP libraries (DOMPDF, PHPMailer)
├── js/                    # Application JS + vendor JS
├── css/                   # Stylesheets
├── images/                # Logos, icons, animations
├── temp/                  # Transient PNG exports (gitignored)
├── config.example.php     # Template — copy to config.php
└── config.php             # Local secrets (gitignored)
```

## Local setup

1. Clone the repo.
2. Copy the config template and fill in real values:
   ```bash
   cp config.example.php config.php
   ```
   Edit `config.php` and set:
   - `$POSTMARK_TOKEN` — Postmark Server API token
   - `$MAIL_FROM` — sender address (must be a verified Sender Signature in Postmark)
   - `$MAIL_FROM_NAME` — display name on outgoing email
3. Ensure `temp/` and `HAQ_DI/save/` are writable by the web server (e.g. `chmod 0775`).
4. Serve with PHP:
   ```bash
   php -S localhost:8000
   ```
   Then open <http://localhost:8000>.

Any standard Apache/Nginx + PHP host will also work. PHP's `curl` extension must be enabled.

## Deployment

See [.claude/commands/deploy.md](.claude/commands/deploy.md) for deployment notes.

## License

All rights reserved. Proprietary — not licensed for external use.

# Teras Coklat Loyalty Program — AGENTS.md

## Project overview

A XAMPP-based PHP loyalty app for "Teras Coklat" (chocolate drink shop). No package manager, no build step, no tests. Served directly by Apache.

**Entrypoint:** `index.php` (dashboard with QR + leaderboard)

## Database

- **MySQL** — `config/database.php`: `localhost`, `root`, no password, `es_coklat_db`
- **Single table** `pelanggan` with columns: `id`, `nama`, `whatsapp`, `total_poin`
- QR tokens are stored as JSON in `cache/qr_token.json` (file-based, not DB)
- `cache/` directory must be writable (0755) — created automatically by `proses.php`

## Key business rules

| Action | Effect |
|---|---|
| Scan QR | +10 poin |
| Redeem | -50 poin (free 1 cup) |
| QR token expiry | 120 seconds |
| QR auto-refresh | Every 60 seconds (JS `setInterval`) |

## Code conventions

- **SQL style:** Direct string concatenation with `mysqli_real_escape_string` or `(int)` casting. Do NOT introduce PDO or query builders.
- **Database connection:** Global `$conn` from `mysqli_connect()`. No dependency injection.
- **Session:** `session_start()` only in `index.php` (used but not functionally).
- **File structure:** PHP logic lives in `includes/proses.php`; all pages `include 'config/database.php'`.
- **CSS:** Custom theme in `assets/css/style.css`. Uses Bootstrap 5.3 CDN, Font Awesome 6 CDN, QRCode.js CDN.

## Actions (routed via `includes/proses.php?aksi=`)

| `aksi` | Method | Description |
|---|---|---|
| `generate_qr` | GET | Generates new QR token, writes to `cache/qr_token.json` |
| `tukar_poin` | GET | Deducts 50 points from member by `id` |
| `reset_poin` | GET | Resets member points to 0 by `id` |
| `self_checkin` | POST | Validates token (120s), adds +10 points or redirects to register |
| `register_and_claim` | POST | Creates member + adds 10 points (requires valid token) |
| `register_member` | POST | Creates member with 0 points (no token needed) |

## Gotchas

- `AGENT.py` at the repo root is a **standalone Python script** unrelated to this web app. Do not modify or reference it for PHP work.
- All forms use `method="POST"` except redeem/reset which are `GET` links with `onclick` confirmation (handled in `assets/js/script.js`).
- QR code points to `checkin.php?token=<token>` — the live URL depends on the server's `window.location.origin`.
- No CSRF protection, no password auth, no HTTPS enforcement. Keep changes consistent with this simplicity.
- `register.php` expects `token` in query string for the "already have account" link; does not validate it.
- `.htaccess` is a no-op (`RewriteEngine On` only) — no URL rewriting in use.

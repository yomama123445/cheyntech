# Rules for all agents (builder and auditor)

Project: CheynTech, a PHP 8 + MySQL/MariaDB phone store (catalog, cart, checkout,
order tracking, admin panel). Frontend is Bootstrap + vanilla JS in assets/js.
Hosting is HestiaCP (Nginx, usually with Apache behind it, plus PHP-FPM), so no Node build step and no Composer unless TASK.md says so. Do not assume .htaccess works; see TASK.md S7.
Scope source of truth: docs/cheyntech_proposal.pdf. Out of scope: automated payment gateways, courier APIs, multi-branch inventory, mobile app, reviews. Do not build these.

## Hard rules
- Never read, print, edit, or commit config/database.php, .env files, or any real credentials.
- Never edit tests/, scripts/, or .github/ unless the TASK item says so.
- One TASK item per run. Touch only the files that item names.
- Use prepared statements for every query. Escape all output (htmlspecialchars) in PHP pages.
- Never return exception messages to the client. Log them with error_log() and send a generic error.
- Schema changes go in database/migrations/NNN_name.sql. Never edit the live database.
- Do not add dependencies or files outside the item's scope. If you must, say why in STATUS.md.

## Definition of done
- `bash tests/smoke.sh` passes and every changed PHP file passes `php -l`.
- The item's own "Done when" check passes.
- STATUS.md has two lines: what changed, and what you verified.

## If an instruction does not match the code
Do not improvise. Write the mismatch in BUILDER_NOTES.md and stop.

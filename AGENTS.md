# Celebrity Management Portal — Project Context & Memory System

> **CRITICAL**: Read MEMORY.md on every session start. It contains the complete state of the project, last session's work, decisions made, and next steps.

## Project Overview
A multi-celebrity fan management portal built on Laravel. Super admin creates celebrity portals on subdomains (`{slug}.managingteam.info`). Each portal is a fully customizable fan community with membership tiers, meet & greet events, private meetups, membership cards, threaded messaging, and payment processing.

> **STRICTLY PHP-BASED PROJECT**: This project is 100% PHP (Laravel + Blade + Livewire + Filament). There is NO Node.js runtime, NO React/Vue frontend, and NO terminal/SSH on the production server (PHP-only cPanel). Node (`npm run build`) is used ONLY locally to compile Vite assets. Never introduce React, TSX, Node-only packages, or anything requiring a server-side Node runtime. Any UI component (including 21st/Magic output) must be ported to Blade + Alpine.js — never pasted as React/TSX.

**Domain**: managingteam.info  
**Admin Panel**: `managingteam.info/admin`  
**Fan Portals**: `{celebrity}.managingteam.info` (wildcard subdomain)

## Memory System
- `AGENTS.md` — This file. Project overview, workflow rules, tech stack, key paths, architecture principles.
- `MEMORY.md` — **Session-by-session log**. Every session's completed work, decisions made (with rationale), known issues, blockers, and precise next steps. This is the canonical state file.
- `.graphify/` — Knowledge graph built by nodesify-graphify for codebase queries.
- `AGENTS.md` + `MEMORY.md` together form the complete persistent memory. **Always read both on session start.**

## Superpowers Integration (OpenCode plugin)
- Superpowers is a skills-based dev methodology (brainstorming → writing-plans → TDD → subagent-driven-development). Installed globally via `~/.config/opencode/opencode.jsonc` `plugin` array.
- **Telemetry is disabled** via `SUPERPOWERS_DISABLE_TELEMETRY=1` (in `~/.bashrc` + `~/.profile`). Never rely on the visual-companion logo/network features; local-only.
- Article shells it persists: `brainstorming` writes design specs to `docs/superpowers/specs/YYYY-MM-DD-<topic>-design.md`; `writing-plans` writes plans in `docs/superpowers/plans/`.
- **Resumption rule**: MEMORY.md's "Next Steps" must cite the active Superpowers spec/plan file path (e.g. `docs/superpowers/plans/YYYY-MM-DD-<topic>.md`) so a new session can open it and resume unchecked tasks without re-deriving context.

## Workflow Rules
1. **Start of session**: Read MEMORY.md completely, then AGENTS.md. This restores full context including where we left off.
2. **Before coding**: If `.graphify/graph_report.md` exists, check it for architecture context before searching files.
3. **Task completion**: Update MEMORY.md with: what was done, all decisions made (with why), any new known issues, and the next steps.
4. **Never lose context**: If unsure what to do next, check MEMORY.md "Next Steps" section. If unclear, ask the user.
5. **State changes**: Log every architectural decision in MEMORY.md with rationale.
6. **Graphify**: Run `nodesify-graphify update .` after significant code changes to keep the knowledge graph current.
7. **Resuming mid-build**: When a session ends mid-feature, the last session's MEMORY.md entry must (a) name the active Superpowers plan/spec file, (b) list the exact next unchecked task, so the following session resumes without asking.

## Tech Stack
- Laravel 13 (PHP 8.3)
- PostgreSQL (Neon — free tier, cold starts cause slow migrations/seeders)
- Blade + Tailwind CSS v4
- Livewire v3 + Filament v3 (admin panel)
- Stripe / Cashier (payment processing — not fully wired yet)
- Laravel Sanctum (API auth — not yet utilized)
- Breeze (Blade stack — auth scaffolding)

## Key Paths
- `app/Models/` — Eloquent models (10+ models)
- `app/Http/Controllers/` — Controllers (PageController, action controllers, auth)
- `resources/views/` — Blade views (`celebrity/` for fan pages, `livewire/` for components)
- `database/migrations/` — DB migrations (18 total)
- `routes/web.php` — Route definitions (3 groups: auth, main domain, subdomain)
- `app/Filament/Admin/Resources/` — Filament admin resources (10 resource groups)
- `app/Livewire/` — Livewire components (Navigation, Cart, Toast)

## Deployment
- **Production**: `https://managingteam.info` (cPanel on UltraProHost)
- **cPanel**: `https://server.ultraprohost.com:2083` — user: `managingteam`
- **cPanel/SSH Password**: `^.o3J3mg+]=&6Xk=` (store in variable: `CPASS='^.o3J3mg+]=&6Xk='`)
- **Production DB**: MySQL — DB: `managingteam_celeb`, user: `managingteam_celeb`
- **Production path**: `/home/managingteam/public_html/` on the server (web root is `public/` inside)
- **Credentials stored**: `.env.production` (gitignored — do not commit)
- **Deploy method**: cPanel UAPI via curl (no sshpass/SFTP needed)

### Proven Deployment Commands (cPanel UAPI via curl)
```bash
CPASS='^.o3J3mg+]=&6Xk='

# 1. Build deployment zip (run from project root)
zip -r managingteam-deploy.zip . -x 'node_modules/*' '.git/*' 'vendor/*' 'public/build/*' 'storage/*.key' '.env' 'managingteam-deploy.zip' 'database/managingteam_celeb.sql'

# 2. Upload zip to server
curl -s -k -u "managingteam:${CPASS}" \
  -X POST "https://server.ultraprohost.com:2083/execute/Fileman/upload_files" \
  --form "dir=/home/managingteam/public_html" \
  --form "overwrite=1" \
  --form "file=@managingteam-deploy.zip"

# 3. Write+run extractor script (uploads to public/, executes, self-deletes)
#    Put this in /tmp/extract.php on your local machine first:
echo '<?php $z=new ZipArchive(); if($z->open("../managingteam-deploy.zip")===TRUE){$z->extractTo("..");$z->close();echo "OK";}else{echo "FAILED";} unlink("extract.php");' > /tmp/extract.php
curl -s -k -u "managingteam:${CPASS}" \
  -X POST "https://server.ultraprohost.com:2083/execute/Fileman/upload_files" \
  --form "dir=/home/managingteam/public_html/public" \
  --form "overwrite=1" \
  --form "file=@/tmp/extract.php"
curl -s -k -m 60 "https://managingteam.info/extract.php"

# 4. Clear bootstrap cache (if site shows 500 — stale cache issue)
#    Write a script that unlinks bootstrap/cache/config.php + cached views:
echo '<?php foreach(["../bootstrap/cache/config.php","../bootstrap/cache/packages.php","../bootstrap/cache/services.php","../bootstrap/cache/routes-v7.php","../bootstrap/cache/events.php"] as$f){if(file_exists($f))unlink($f);} foreach(glob("../storage/framework/views/*")as$vf){if(is_file($vf))unlink($vf);} echo "OK"; unlink(__FILE__);' > /tmp/clear-cache.php
curl -s -k -u "managingteam:${CPASS}" \
  -X POST "https://server.ultraprohost.com:2083/execute/Fileman/upload_files" \
  --form "dir=/home/managingteam/public_html/public" \
  --form "overwrite=1" \
  --form "file=@/tmp/clear-cache.php"
curl -s -k -m 30 "https://managingteam.info/clear-cache.php"

# 5. Verify
curl -s -o /dev/null -w "%{http_code}" "https://managingteam.info"
curl -s -o /dev/null -w "%{http_code}" "https://jennie.managingteam.info"
```

### Production Troubleshooting Recipes
| Symptom | Fix |
|---------|-----|
| **500 error on all pages** | Stale `bootstrap/cache/config.php` — clear it (step 4 above) |
| **404 on fan portals** | Wildcard subdomain not set up in cPanel or DNS |
| **Login redirect fails** | Check `APP_URL` in `.env.production` |
| **File uploads not showing** | Run `php artisan storage:link` (storage symlink) |
| **Stale views shown** | Old compiled Blade views — clear `storage/framework/views/` |
| **Campaign emails not sending** | 1) Check cron entry exists in cPanel 2) Run `php artisan campaigns:process` manually to test 3) Verify `QUEUE_CONNECTION=sync` or configured in `.env` |

### Email Campaign Cron Setup (Post-Deployment)
After deploying, add ONE cron entry in cPanel. Never change it — it handles all future campaigns automatically:
```
* * * * * /usr/local/bin/php /home/managingteam/public_html/artisan campaigns:process >/dev/null 2>&1
```
The command runs every minute, processes a batch (respecting 50/hr + 1,000/day limits), and exits. If cron is unavailable, campaigns still advance when the admin visits any admin page (safety net processes 3/request).

## Architecture Principles
1. **Celebrity config JSON** is the single source of truth for all per-celebrity customization (theme, content, pricing, features, payments)
2. **Subdomain routing** isolates fan portals — each `{slug}.managingteam.info` renders a different celebrity
3. **Fan isolation** via `celebrity_fan` pivot table — fans are linked to exactly one celebrity
4. **One admin** manages all celebrities from `managingteam.info/admin`
5. **Threaded messaging** — `parent_id` on messages table enables fan↔admin conversations
6. **All fan queries scoped** by `celebrity_id` — no cross-celebrity data leakage
7. **Never `json_encode()` Eloquent `array`/`json` cast attributes** — Eloquent auto-encodes on `setAttribute`; explicit encoding causes double-encoding that crashes Filament Repeater fields

## UI Development with 21st MCP (Magic)
- **ALWAYS use the 21st MCP server** (registered in `~/.config/opencode/opencode.jsonc` as `21st`, remote HTTP at `https://21st.dev/api/mcp`, API key already saved there — never ask the user for it again) when building or redesigning any user interface.
- **Skill**: the `designing-uis-with-21st` skill (global, `~/.config/opencode/skills/`) governs this workflow — invoke it whenever UI work begins (it is auto-discovered and loads alongside superpowers' brainstorming/planning skills). Its rule: every interface originates from a 21st `generate`/`search` call, then gets ported.
- 21st MCP (formerly Magic MCP) generates modern React/Tailwind components from natural language (`generate`), searches a 10,000+ component catalog (`search`/`get_inspiration`), and refines existing components.
- **Blade translation rule**: this project is Blade + Tailwind + Alpine, NOT React. Components generated by 21st must be **ported** — take the Tailwind markup/CSS and translate to Blade (`resources/views/celebrity/`) + Alpine.js, wiring Livewire where needed. Never paste React/TSX directly.
- The 21st server is remote (no npm install, no Node runtime) — works fine with the PHP-only cPanel hosting.

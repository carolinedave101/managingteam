# Celebrity Management Portal — Project Context & Memory System

> **CRITICAL**: Read MEMORY.md on every session start. It contains the complete state of the project, last session's work, decisions made, and next steps.

## Project Overview
A multi-celebrity fan management portal built on Laravel. Super admin creates celebrity portals on subdomains (`{slug}.managingteam.info`). Each portal is a fully customizable fan community with membership tiers, meet & greet events, private meetups, membership cards, threaded messaging, and payment processing.

**Domain**: managingteam.info  
**Admin Panel**: `managingteam.info/admin`  
**Fan Portals**: `{celebrity}.managingteam.info` (wildcard subdomain)

## Memory System
- `AGENTS.md` — This file. Project overview, workflow rules, tech stack, key paths, architecture principles.
- `MEMORY.md` — **Session-by-session log**. Every session's completed work, decisions made (with rationale), known issues, blockers, and precise next steps. This is the canonical state file.
- `.graphify/` — Knowledge graph built by nodesify-graphify for codebase queries.
- `AGENTS.md` + `MEMORY.md` together form the complete persistent memory. **Always read both on session start.**

## Workflow Rules
1. **Start of session**: Read MEMORY.md completely, then AGENTS.md. This restores full context including where we left off.
2. **Before coding**: If `.graphify/graph_report.md` exists, check it for architecture context before searching files.
3. **Task completion**: Update MEMORY.md with: what was done, all decisions made (with why), any new known issues, and the next steps.
4. **Never lose context**: If unsure what to do next, check MEMORY.md "Next Steps" section. If unclear, ask the user.
5. **State changes**: Log every architectural decision in MEMORY.md with rationale.
6. **Graphify**: Run `nodesify-graphify update .` after significant code changes to keep the knowledge graph current.

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
- **Production DB**: MySQL — DB: `managingteam_celeb`, user: `managingteam_celeb`
- **Production path**: `/public_html/` on the server
- **Credentials stored**: `.env.production` (gitignored — do not commit)
- **Deploy method**: Upload files via cPanel File Manager API, run seeders via web route

## Architecture Principles
1. **Celebrity config JSON** is the single source of truth for all per-celebrity customization (theme, content, pricing, features, payments)
2. **Subdomain routing** isolates fan portals — each `{slug}.managingteam.info` renders a different celebrity
3. **Fan isolation** via `celebrity_fan` pivot table — fans are linked to exactly one celebrity
4. **One admin** manages all celebrities from `managingteam.info/admin`
5. **Threaded messaging** — `parent_id` on messages table enables fan↔admin conversations
6. **All fan queries scoped** by `celebrity_id` — no cross-celebrity data leakage

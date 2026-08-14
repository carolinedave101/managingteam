# Fan-Facing UI Beautification — "Cinematic Elevation" Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Elevate all fan-facing UI (guest + logged-in, admin excluded) with a cinematic premium design language ported from the 21st catalog, preserving the per-celebrity theming system.

**Architecture:** Add shared design tokens (CSS classes + one Alpine component) to `app.css`/`app.js`, then apply them page-by-page in batches. Each batch is independently verifiable (Vite build + test suite + manual route check). No backend changes; existing behavior (payment toggles, modals, Echo, Alpine stores, Livewire polling) must be preserved exactly.

**Tech Stack:** Laravel 13 Blade, Tailwind CSS v4, Alpine.js, Livewire v3. No GSAP, no React, no new packages.

**Spec:** `docs/superpowers/specs/2026-08-14-ui-beautification-design.md`

## Global Constraints

1. PHP-only stack — Blade + Tailwind v4 + Alpine.js only. Never introduce React/TSX/GSAP/Node-only packages.
2. Per-celebrity theming intact: `--accent`, `--accent-secondary`, `--page-bg-*`, fonts. New utilities use `var(--accent)` or config-driven colors — never hardcode brand colors.
3. Category hero variants (movie_star / country_singer / adult_star / musician) keep distinct identities; elevation is additive.
4. Preserve ALL interactive behavior: `paymentMethodToggle()`, modal open/close + fixed-header/scrollable-body pattern, gallery lightbox, Echo listeners, Alpine stores (`cart`/`wallet`/`notifications`/`ui`), Livewire `wire:poll`, routes `route('celebrity.*', ['celebrity' => $celebrity->slug])`.
5. Inline `<style>`/`<script>` allowed for page-specific effects (layout has no `@stack`).
6. No `json_encode()` on cast attributes; no migrations; no new columns.
7. `x-cloak` CSS stays for Alpine-gated elements.
8. All 30 existing tests must stay green; `npm run build` must pass after every task.
9. Local dev: `php artisan serve --port=8005`; portals at `{slug}.localhost:8005`.
10. Deploy to production only after Task 15 (final batch).

---

### Task 1: Shared Cinematic Design Language (CSS tokens + Alpine sheen)

**Files:**
- Modify: `resources/css/app.css` (append at end)
- Modify: `resources/js/app.js` (append at end)
- Test: none (asset-level; verified by build + visual checks in later tasks)

**Interfaces:**
- Consumes: nothing (foundational)
- Produces: classes `.text-matte`, `.text-matte-accent`, `.film-grain`, `.bg-grid-masked`, `.depth-card`, `.card-sheen`, enhanced `.btn-primary`; Alpine component `sheenCard` (used via `x-data="sheenCard"` on any element)

- [ ] **Step 1: Append CSS tokens to `resources/css/app.css`**

```css
/* ─── Cinematic Elevation Tokens (Task 1) ─── */

.text-matte {
    background: linear-gradient(180deg, #fff 0%, color-mix(in srgb, #fff 55%, transparent) 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 10px 20px rgba(0,0,0,0.35)) drop-shadow(0 2px 4px rgba(0,0,0,0.25));
}

.text-matte-accent {
    background: linear-gradient(180deg, var(--accent-deep, var(--accent)) 0%, var(--accent) 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 6px 16px var(--accent-glow, rgba(0,0,0,0.15)));
}

.film-grain {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 40;
    opacity: 0.05;
    mix-blend-mode: overlay;
    background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><filter id="n"><feTurbulence type="fractalNoise" baseFrequency="0.8" numOctaves="3" stitchTiles="stitch"/></filter><rect width="100%" height="100%" filter="url(%23n)"/></svg>');
}

.bg-grid-masked {
    position: absolute;
    inset: 0;
    pointer-events: none;
    background-size: 60px 60px;
    background-image:
        linear-gradient(to right, color-mix(in srgb, var(--accent) 6%, transparent) 1px, transparent 1px),
        linear-gradient(to bottom, color-mix(in srgb, var(--accent) 6%, transparent) 1px, transparent 1px);
    mask-image: radial-gradient(ellipse at center, black 0%, transparent 70%);
    -webkit-mask-image: radial-gradient(ellipse at center, black 0%, transparent 70%);
}

.depth-card {
    position: relative;
    box-shadow:
        0 40px 100px -20px rgba(0, 0, 0, 0.35),
        0 20px 40px -20px rgba(0, 0, 0, 0.25),
        inset 0 1px 2px rgba(255, 255, 255, 0.6),
        inset 0 -2px 4px rgba(0, 0, 0, 0.06);
}

.card-sheen {
    position: absolute;
    inset: 0;
    border-radius: inherit;
    pointer-events: none;
    z-index: 10;
    background: radial-gradient(600px circle at var(--mouse-x, 50%) var(--mouse-y, 50%), rgba(255, 255, 255, 0.14) 0%, transparent 40%);
    mix-blend-mode: screen;
    transition: opacity 0.3s ease;
}

.btn-primary {
    box-shadow:
        0 0 0 1px rgba(0, 0, 0, 0.05),
        0 2px 4px rgba(0, 0, 0, 0.1),
        0 12px 24px -4px var(--accent-glow, rgba(0, 0, 0, 0.2)),
        inset 0 1px 1px rgba(255, 255, 255, 0.6),
        inset 0 -3px 6px rgba(0, 0, 0, 0.06);
}
.btn-primary:hover { transform: translateY(-3px); }
.btn-primary:active { transform: translateY(1px); }
```

- [ ] **Step 2: Append Alpine `sheenCard` component to `resources/js/app.js`**

```js
document.addEventListener('alpine:init', () => {
    Alpine.data('sheenCard', () => ({
        raf: null,
        init() {
            const card = this.$el;
            const move = (e) => {
                if (window.scrollY > window.innerHeight * 2.5) return;
                cancelAnimationFrame(this.raf);
                this.raf = requestAnimationFrame(() => {
                    const rect = card.getBoundingClientRect();
                    card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
                    card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
                });
            };
            card.addEventListener('mousemove', move);
        },
    }));
});
```

- [ ] **Step 3: Build assets**

Run: `npm run build`
Expected: exits 0, no errors.

- [ ] **Step 4: Run test suite**

Run: `php artisan test`
Expected: 30 passed, 0 failed.

- [ ] **Step 5: Commit**

```bash
git add resources/css/app.css resources/js/app.js
git commit -m "feat(ui): add cinematic elevation design tokens (matte text, film grain, grid, depth cards, sheen)"
```

---

### Task 2: Home Hero — All 4 Category Variants

**Files:**
- Modify: `resources/views/celebrity/partials/hero.blade.php` (all 4 hero branches)

**Interfaces:**
- Consumes: `.text-matte`, `.film-grain`, `.bg-grid-masked`, `.depth-card`, `.card-sheen`, `sheenCard`, `.btn-primary` hover/press (Task 1)
- Produces: elevated hero markup pattern applied identically across category branches; later tasks reference "the Task 2 hero treatment"

- [ ] **Step 1: Add cinematic overlays + matte headline to each of the 4 hero branches**

For EVERY branch (movie_star, country_singer, adult_star, musician), inside the `<section>` right after the opening tag, insert:

```html
<div class="film-grain" aria-hidden="true"></div>
<div class="bg-grid-masked" aria-hidden="true"></div>
```

Then replace the branch's `<h1 ...>` headline element with the matte treatment. Keep the existing `{!! $content['hero_title'] ?? $catDefaults['title'] !!}` content and category-specific inline colors/fonts. Pattern (musician branch — light bg):

```html
<h1 class="text-4xl md:text-7xl lg:text-8xl font-bold leading-[1.05] tracking-tight text-matte-accent">
    {!! $content['hero_title'] ?? $catDefaults['title'] !!}
</h1>
```

Dark branches (movie_star / country_singer / adult_star) keep their existing white headline but add a `.text-matte` span treatment on the highlighted word if it uses inline `<span style="color:#...">` — replace those spans with `<span class="text-matte">` (keep the gold/amber color by leaving the span inline color where the branch already hardcodes it — do NOT change category identity).

- [ ] **Step 2: Wrap the portrait card in sheen depth treatment + add trust-stats row**

In all 4 branches, on the portrait container `<div class="relative">` (the one containing the rounded-3xl image), add `x-data="sheenCard"`, and to the image card div add classes `depth-card` plus a sheen layer:

```html
<div class="relative" x-data="sheenCard">
    <div class="absolute inset-0 rounded-3xl opacity-20 blur-3xl" style="background: ...existing...;"></div>
    <div class="relative w-64 h-64 md:w-96 md:h-96 rounded-3xl overflow-hidden shadow-2xl depth-card" style="...existing...;">
        <div class="card-sheen" aria-hidden="true"></div>
        ...existing image/fallback markup...
    </div>
    ...existing floating chip...
</div>
```

Under the CTA button row (inside the left text column, after the `@auth`/`@guest` buttons block), add a trust-stats row (values hardcoded per category to match each branch's existing stats flavor):

```html
<div class="flex flex-wrap justify-center md:justify-start gap-x-8 gap-y-3 pt-4">
    <div class="text-center md:text-left">
        <div class="text-xl md:text-2xl font-bold {{ $cat === 'movie_star' ? '' : ($cat === 'country_singer' ? '' : ($cat === 'adult_star' ? '' : 'text-matte-accent')) }}" style="color: ...branch accent...;">{{ count($tiers) }}+</div>
        <div class="text-xs font-medium" style="color: rgba(255,255,255,0.5);">Membership Tiers</div>
    </div>
    <div class="text-center md:text-left">
        <div class="text-xl md:text-2xl font-bold" style="color: ...branch accent...;">10K+</div>
        <div class="text-xs font-medium" style="color: rgba(255,255,255,0.5);">Fans Worldwide</div>
    </div>
    <div class="text-center md:text-left">
        <div class="text-xl md:text-2xl font-bold" style="color: ...branch accent...;">24/7</div>
        <div class="text-xs font-medium" style="color: rgba(255,255,255,0.5);">Fan Support</div>
    </div>
</div>
```

NOTE: For dark branches use the branch's accent color (e.g. `#fbbf24`, `#f59e0b`, `#ec4899`) in `style="color:"`; for the musician (light) branch use `style="color: var(--accent-deep);"` and `text-matte-accent` on the values. The `{{ $cat === ... }}` ternary is a placeholder to think about — simply write one explicit block per branch instead (4 copies), no ternary needed.

- [ ] **Step 3: Build + test**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.

- [ ] **Step 4: Manual verify**

Run: `php artisan serve --port=8005` (background), then check:
- `http://jennie.localhost:8005` (musician hero — light, matte accent headline, grid+film grain, sheen portrait, trust row)
- `http://samuel-l-jackson.localhost:8005` (movie_star hero — dark, cinematic)
- `http://carrie-underwood.localhost:8005` (country_singer) — adjust to a real seeded slug if different
- `http://lisa.localhost:8005` (adult_star if Lisa is adult_star — otherwise pick any adult_star slug from DB)

Expected: no layout breakage, hero fills viewport width, CTAs visible, no console errors.

- [ ] **Step 5: Commit**

```bash
git add resources/views/celebrity/partials/hero.blade.php
git commit -m "feat(ui): cinematic hero elevation — film grain, masked grid, matte headline, sheen portrait, trust stats"
```

---

### Task 3: Home Page Sections (stats, gallery, about, features, tiers, events, testimonials, CTA)

**Files:**
- Modify: `resources/views/celebrity/home.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens + Task 2 hero; uses existing variables `$content`, `$defaults`, `$tiers`, `$features`, `$events`, `$gallery`, `$celebrity`
- Produces: elevated home sections; establishes per-section class patterns reused by later pages

- [ ] **Step 1: Elevate stats bar**

In the STATS section (`glass-strong rounded-2xl p-8 md:p-12`), change container to `depth-card` + `x-data="sheenCard"` with a sheen child:

```html
<div class="glass-strong depth-card rounded-2xl p-8 md:p-12" x-data="sheenCard">
    <div class="card-sheen" aria-hidden="true"></div>
    ...existing grid...
</div>
```

Change each stat value from `<div class="text-3xl md:text-4xl font-bold count-highlight">` to `<div class="text-3xl md:text-4xl font-bold count-highlight text-matte-accent">`.

- [ ] **Step 2: Elevate gallery section**

On the GALLERY section heading, change `Moments with <span class="gradient-text-gold">{{ $celebrity->name }}</span>` — keep as-is (already gold). Add to each gallery tile `group-hover:scale-110` stays; add a subtle film-grain overlay div inside each tile:

```html
<div class="film-grain" aria-hidden="true"></div>
```

immediately after the tile's opening `<div class="group relative aspect-[4/5] ...">`. Keep lightbox script untouched.

- [ ] **Step 3: Elevate about section**

On the ABOUT portrait container (`<div class="relative">` wrapping `aspect-[4/5] rounded-3xl`), add `x-data="sheenCard"`, add `depth-card` to the image wrapper, and insert `<div class="card-sheen" aria-hidden="true"></div>` right after its opening tag. The "Years" corner badge stays.

- [ ] **Step 4: Elevate features grid**

On each feature `<a>` card, add `depth-card` to the class list (keep `card-glow bg-white rounded-2xl p-8 border shadow-sm hover:shadow-xl`), add `x-data="sheenCard"` and insert `<div class="card-sheen" aria-hidden="true"></div>` as first child. Keep the icon tile, title, description, "Learn more" link exactly as-is.

- [ ] **Step 5: Elevate pricing tier cards**

On each tier card div, add `depth-card` (keep `group relative bg-white rounded-2xl p-8 border shadow-sm ... card-glow ring-glow-hover`). Keep BEST SELLER ribbon logic (there is no ribbon markup currently — the middle-tier emphasis is via `featured` on membership page; on home keep all three equal but with depth). No other changes to tier content.

- [ ] **Step 6: Elevate event cards**

On each event card wrapper add `depth-card` (keep existing classes + `card-glow`). No other changes.

- [ ] **Step 7: Elevate CTA banner**

In the final CTA `<section>`, right after the opening tag insert `<div class="film-grain" aria-hidden="true"></div>`. Keep gradient background + floating orbs + white buttons.

- [ ] **Step 8: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: `http://jennie.localhost:8005` — check stats sheen follows mouse, gallery tiles render, about portrait sheen, feature cards hover, tier cards depth, CTA grain. Scroll behavior smooth, lightbox still works.

- [ ] **Step 9: Commit**

```bash
git add resources/views/celebrity/home.blade.php
git commit -m "feat(ui): elevate home page sections — depth cards, sheen, matte stats, film grain"
```

---

### Task 4: Dashboard

**Files:**
- Modify: `resources/views/celebrity/dashboard.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; existing view variables (`$stats`, `$onboarding`, `$wallet`, `$recentMessages`, `$celebrity`, etc. — do not rename)
- Produces: dashboard with depth-card stat/feature cards; preserves `data-wallet-balance`, `wire:` bindings, unread badge

- [ ] **Step 1: Add depth + sheen to stat cards**

Locate the dashboard stats row (`flex flex-wrap justify-center gap-* [&>*]:grow [&>*]:basis-48 ...`). For each stat card div add `depth-card` and `x-data="sheenCard"` + `<div class="card-sheen" aria-hidden="true"></div>` as first child. Keep `data-wallet-balance` attribute on the wallet card's balance element (critical — Echo updates it).

- [ ] **Step 2: Add depth to feature cards + onboarding tracker**

For each feature-card in the dashboard feature grid, add `depth-card` + sheen (same pattern). For the onboarding progress card, add `depth-card` and keep `.progress-bar`/`.progress-bar-fill` markup intact.

- [ ] **Step 3: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: login as `sarah@demo.com` / `demo1234!` on `http://jennie.localhost:8005/login`, go to dashboard — cards sheen, wallet balance shows, quick actions work, no console errors.

- [ ] **Step 4: Commit**

```bash
git add resources/views/celebrity/dashboard.blade.php
git commit -m "feat(ui): dashboard elevation — depth cards and sheen on stats, features, onboarding"
```

---

### Task 5: Wallet Page

**Files:**
- Modify: `resources/views/celebrity/wallet.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; keeps `id="wallet-balance"` (Alpine store binding), top-up modal (fixed header + scrollable body), `x-payment-methods` usage, "Pending Deposits" section

- [ ] **Step 1: Elevate balance card**

Balance card: add `depth-card` + `x-data="sheenCard"` + sheen child. Balance amount keeps `price-glow price-gold` classes. Withdraw button unchanged.

- [ ] **Step 2: Elevate transaction history + pending deposits**

Wrap the two history sections' container cards with `depth-card` (keep `.status-badge` markup). Do not touch the top-up modal structure (fixed header + scrollable body from Session 77) or the `{{ $celebrity->name }} Management Team` creator label logic.

- [ ] **Step 3: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: logged-in on wallet page — balance card sheen, top-up modal opens with fixed header, pending deposits section renders.

- [ ] **Step 4: Commit**

```bash
git add resources/views/celebrity/wallet.blade.php
git commit -m "feat(ui): wallet page elevation — depth balance card, history polish"
```

---

### Task 6: Withdraw Page

**Files:**
- Modify: `resources/views/celebrity/withdraw.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; keeps balance card, request form, saved accounts sidebar, add-account modal (Alpine `x-model` dynamic fields), withdrawal history badges

- [ ] **Step 1: Apply depth-card + sheen to the three main containers** (balance card, withdrawal form card, saved accounts sidebar). Keep all `x-model`/`x-show` bindings and status badge colors untouched.

- [ ] **Step 2: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: logged-in withdraw page — cards sheen, add-account modal type switching still works (bank/CashApp/PayPal/crypto fields).

- [ ] **Step 3: Commit**

```bash
git add resources/views/celebrity/withdraw.blade.php
git commit -m "feat(ui): withdraw page elevation — depth cards on balance, form, accounts"
```

---

### Task 7: Membership Page

**Files:**
- Modify: `resources/views/celebrity/membership.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; keeps `.tier-card` + `featured` variant, subscribe modal (fixed header + scrollable body), `x-payment-methods` with `:price="$tier['price']"` + `:celebrity="$celebrity"`, "How it Works" guide, FAQ tips

- [ ] **Step 1: Elevate tier cards**

Add `depth-card` + `x-data="sheenCard"` + sheen child to each `.tier-card` (keep `featured` class + BEST SELLER ribbon + `price-glow` prices). Keep tier color bars, benefits lists, CTA buttons.

- [ ] **Step 2: Elevate guide cards + modal body**

Add `depth-card` to each `.guide-card`/step card. In the subscribe modal, keep the fixed header + scrollable body structure; no visual change needed inside beyond existing styling.

- [ ] **Step 3: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: membership page — tier cards sheen, featured ribbon intact, modal opens with fixed header, payment-methods toggles work.

- [ ] **Step 4: Commit**

```bash
git add resources/views/celebrity/membership.blade.php
git commit -m "feat(ui): membership page elevation — depth tier cards, guide polish"
```

---

### Task 8: Meet & Greet Page

**Files:**
- Modify: `resources/views/celebrity/meet-greet.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; keeps event cards, purchase modal (fixed header + scrollable body), quantity selector, `x-payment-methods` with `:price="$event->price"` + `:celebrity="$celebrity"`

- [ ] **Step 1: Elevate event cards** — add `depth-card` + `x-data="sheenCard"` + sheen child to each event card (keep gradient date header, `price-glow` price, location icon row). Keep the modal structure untouched.

- [ ] **Step 2: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: meet-greet page — cards sheen, modal fixed header + scrollable body, quantity changes total.

- [ ] **Step 3: Commit**

```bash
git add resources/views/celebrity/meet-greet.blade.php
git commit -m "feat(ui): meet & greet elevation — depth event cards"
```

---

### Task 9: Membership Card Page

**Files:**
- Modify: `resources/views/celebrity/membership-card.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; KEEP the existing 3D gift-card flip/tilt (inline `<style>`/`<script>` + `card3d()`) — it is already premium; restyle only the surrounding page (fee banner, redeem form, perks bar, claimed states)

- [ ] **Step 1: Elevate surrounding sections**

- Fee banner (`banner-gradient-soft`): add `depth-card` + sheen.
- "Redeem Your Card" form card: add `depth-card` + sheen (keep tier-free form, `x-payment-methods` with `:price="$cardFee"` + `:celebrity="$celebrity"`, gradient CTA).
- Perks bar: add `depth-card` to the container.
- Claimed states: add `depth-card` to the status cards.
- DO NOT touch the 3D card markup, its inline `<style>`/`<script>`, or `card3d()`.

- [ ] **Step 2: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: membership-card page — 3D card flips/tilts as before, redeem form renders, sheen on surrounding cards.

- [ ] **Step 3: Commit**

```bash
git add resources/views/celebrity/membership-card.blade.php
git commit -m "feat(ui): membership card page elevation — surrounding sections only"
```

---

### Task 10: Giveaways Page

**Files:**
- Modify: `resources/views/celebrity/giveaways.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; keeps two-step entry modal (question → payment, Alpine `x-data="{ step: 'question', note: '' }"` + `giveaway-reset-{id}` events + character counter), "Just for You" badge, `x-payment-methods` usage, entry history table

- [ ] **Step 1: Elevate giveaway cards** — add `depth-card` + `x-data="sheenCard"` + sheen child to each giveaway card (keep prize amount `price-glow price-gold`, status badges, dates, "Just for You" badge). Do NOT touch the modal structure (two-step flow + fixed header/scrollable body).

- [ ] **Step 2: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass (incl. `GiveawayEnterTest`).
Manual: giveaways page — cards sheen, modal two-step flow works, note counter counts.

- [ ] **Step 3: Commit**

```bash
git add resources/views/celebrity/giveaways.blade.php
git commit -m "feat(ui): giveaways elevation — depth prize cards"
```

---

### Task 11: Messages + Apply + Private Meetup + Custom Page

**Files:**
- Modify: `resources/views/celebrity/messages.blade.php`
- Modify: `resources/views/celebrity/apply.blade.php`
- Modify: `resources/views/celebrity/private-meetup.blade.php`
- Modify: `resources/views/celebrity/custom-page.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; messages keeps chat-bubble UI, collapsible threads, `x-user-avatar`, unread indicators, inline reply forms; apply keeps fee banner + `x-payment-methods` with `:price="$fee"` + `:celebrity="$celebrity"` + `enctype="multipart/form-data"`; private-meetup keeps duration pricing table + `x-payment-methods` with `:price="$minMeetupPrice"`; custom-page keeps `{!! $page->content !!}` rendering

- [ ] **Step 1: Messages** — add `depth-card` + sheen to thread cards (`border-rose-300` unread state must remain visible — sheen is inside, border untouched). Keep bubbles, avatars, reply forms.

- [ ] **Step 2: Apply** — add `depth-card` + sheen to the form card (keep `.form-input` classes, fee banner, guide steps, payment component). 

- [ ] **Step 3: Private Meetup** — add `depth-card` + sheen to the request form card and pricing table card (keep `price-glow price-gold` pricing, "what happens next" `banner-gradient` card).

- [ ] **Step 4: Custom page** — wrap `{!! $page->content !!}` in a `max-w-3xl mx-auto glass-strong depth-card rounded-2xl p-8 md:p-12` container (keep all content untouched).

- [ ] **Step 5: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: messages (thread expand/reply), apply (fee banner + payment toggle), private-meetup (duration pricing), custom page (renders content).

- [ ] **Step 6: Commit**

```bash
git add resources/views/celebrity/messages.blade.php resources/views/celebrity/apply.blade.php resources/views/celebrity/private-meetup.blade.php resources/views/celebrity/custom-page.blade.php
git commit -m "feat(ui): elevate messages, apply, private meetup, custom page"
```

---

### Task 12: Auth Pages + Guest Layout

**Files:**
- Modify: `resources/views/layouts/guest.blade.php`
- Modify: `resources/views/auth/login.blade.php`
- Modify: `resources/views/auth/register.blade.php`
- Modify: `resources/views/auth/forgot-password.blade.php`
- Modify: `resources/views/auth/reset-password.blade.php`
- Modify: `resources/views/auth/confirm-password.blade.php`
- Modify: `resources/views/auth/verify-email.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; CRITICAL: keep `url()->current()` form actions, subdomain-only behavior, `$celebrity ?? null` handling, existing `auth-input`/`auth-card`/`auth-btn` classes, favicon/manifest links

- [ ] **Step 1: Guest layout** — add `film-grain` + `bg-grid-masked` divs inside the split-screen cover/background layer (light side). Keep glass auth card, floating orbs, animated blobs, per-celebrity `var(--accent)` CSS. Wordmark stays.

- [ ] **Step 2: Login + register** — apply `.btn-tactile`-style shadow to the `.auth-btn` submit (add the same layered box-shadow via a new `.auth-btn` box-shadow rule in `app.css` or inline; simplest: extend `.btn-primary` treatment into `.auth-btn` by appending to its existing rule in `app.css`):

```css
.auth-btn {
    box-shadow:
        0 0 0 1px rgba(0, 0, 0, 0.05),
        0 2px 4px rgba(0, 0, 0, 0.1),
        0 12px 24px -4px var(--accent-glow, rgba(0, 0, 0, 0.2)),
        inset 0 1px 1px rgba(255, 255, 255, 0.5),
        inset 0 -3px 6px rgba(0, 0, 0, 0.06);
}
```

Keep all icon-prefixed inputs, social buttons, dividers, entrance animations unchanged.

- [ ] **Step 3: Other auth views** (forgot/reset/confirm/verify) — add `depth-card` to the small form card containers (they already use glass classes). No other changes.

- [ ] **Step 4: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: `http://jennie.localhost:8005/login` and `/register` — form action is current URL, glass card elevated, buttons tactile. Main domain `/login` still 404.

- [ ] **Step 5: Commit**

```bash
git add resources/views/layouts/guest.blade.php resources/views/auth/ resources/css/app.css
git commit -m "feat(ui): auth pages elevation — film grain, tactile buttons, depth cards"
```

---

### Task 13: Landing + Celebrities Directory

**Files:**
- Modify: `resources/views/pages/landing.blade.php`
- Modify: `resources/views/pages/celebrities.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; landing keeps the portal-link entry form + POST `/redirect` + flash error display; directory keeps the table with avatar/name/category badge/gender/country/Visit Portal link

- [ ] **Step 1: Landing** — wrap the form card in `depth-card` + `x-data="sheenCard"` + sheen child (keep branded hero bg, wordmark footer, input + submit button). Add `film-grain` to the page's hero background layer if it has one (it uses `hero-gradient` — add grain div right after the section opening tag).

- [ ] **Step 2: Directory** — wrap the table container in `depth-card` (keep all columns, badges, links).

- [ ] **Step 3: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: `http://localhost:8005` — form redirects to `jennie.localhost:8005` on submit; `http://localhost:8005/celebrities` renders table.

- [ ] **Step 4: Commit**

```bash
git add resources/views/pages/landing.blade.php resources/views/pages/celebrities.blade.php
git commit -m "feat(ui): landing + directory elevation — depth cards, film grain"
```

---

### Task 14: Shared Components (Navigation, Footer, Payment Methods)

**Files:**
- Modify: `resources/views/livewire/navigation.blade.php`
- Modify: `resources/views/components/footer.blade.php`
- Modify: `resources/views/components/payment-methods.blade.php`

**Interfaces:**
- Consumes: Task 1 tokens; CRITICAL: navigation keeps wallet balance pill (`data-wallet-balance`), notification bell with unread badge, logo image, `wire:poll.10s`; footer keeps dynamic links; payment-methods keeps `window.paymentMethodToggle()` behavior, `old($selectName, 'bank_transfer')`, wallet option + insufficient label, QR display, `:celebrity`/`:price` props — ZERO behavior change

- [ ] **Step 1: Navigation** — make the header sticky bar `backdrop-blur-xl` glass with a subtle bottom border (`border-b border-white/10` on glass bg). No structural change; keep all `wire:` attributes and Alpine bindings.

- [ ] **Step 2: Footer** — wrap the footer in a subtle top gradient divider; keep all columns/links.

- [ ] **Step 3: Payment methods component** — restyle only the `<select class="form-input">` and file input with existing `.form-input` classes (already done in Session 23 — verify they're present; if present, no change needed). Add `depth-card` to the method detail info boxes (crypto/bank/paypal/offline boxes). DO NOT touch the `<script>` toggle logic or any `id`/`name` attributes.

- [ ] **Step 4: Build + test + manual verify**

Run: `npm run build && php artisan test`
Expected: build exits 0; 30 tests pass.
Manual: on any portal — nav wallet pill updates via Echo (hard to test locally without Reverb; at minimum confirm pill renders with server value), payment-methods toggles on membership modal still show/hide correctly, footer renders.

- [ ] **Step 5: Commit**

```bash
git add resources/views/livewire/navigation.blade.php resources/views/components/footer.blade.php resources/views/components/payment-methods.blade.php
git commit -m "feat(ui): shared components elevation — glass nav, footer, payment boxes"
```

---

### Task 15: Finalization + Production Deploy

**Files:**
- Modify: none (verification + deployment only)

**Interfaces:**
- Consumes: all prior tasks

- [ ] **Step 1: Full verification**

Run: `npm run build && php artisan test && vendor/bin/pint --dirty`
Expected: build exits 0; 30 tests pass; Pint clean (no files reported or only pre-existing style fixes).

- [ ] **Step 2: Visual spot-check across category portals**

With `php artisan serve --port=8005`, check:
- `jennie.localhost:8005` (musician), a movie_star portal, a country_singer portal, an adult_star portal
- Login page + dashboard + wallet + membership + messages on `jennie.localhost:8005`
- Landing + directory on `localhost:8005`

Expected: no broken layouts, all interactive elements work, theming per-celebrity intact.

- [ ] **Step 3: Update MEMORY.md**

Append a session entry documenting: design language added (Task 1 tokens), per-page changes, decisions (no GSAP; sheen via Alpine; catalog-derived language), build/test results, and the deployment performed. Note the plan file path in Next Steps convention.

- [ ] **Step 4: Commit**

```bash
git add MEMORY.md
git commit -m "docs: log UI beautification session in MEMORY.md"
```

- [ ] **Step 5: Build deployment zip + upload + extract + clear cache**

Run (from project root; `CPASS` from AGENTS.md):

```bash
zip -r managingteam-deploy.zip . -x 'node_modules/*' '.git/*' 'vendor/*' 'public/build/*' 'storage/*.key' '.env' 'managingteam-deploy.zip' 'database/managingteam_celeb.sql'
curl -s -k -u "managingteam:${CPASS}" -X POST "https://server.ultraprohost.com:2083/execute/Fileman/upload_files" --form "dir=/home/managingteam/public_html" --form "overwrite=1" --form "file=@managingteam-deploy.zip"
echo '<?php $z=new ZipArchive(); if($z->open("../managingteam-deploy.zip")===TRUE){$z->extractTo("..");$z->close();echo "OK";}else{echo "FAILED";} unlink("extract.php");' > /tmp/extract.php
curl -s -k -u "managingteam:${CPASS}" -X POST "https://server.ultraprohost.com:2083/execute/Fileman/upload_files" --form "dir=/home/managingteam/public_html/public" --form "overwrite=1" --form "file=@/tmp/extract.php"
curl -s -k -m 60 "https://managingteam.info/extract.php"
```

Note: the zip excludes `public/build/*` — but the redesign changed compiled assets, so this exclusion must be removed for this deploy. Use the same command with `public/build` NOT in the exclusion list, and also upload the built assets:

```bash
zip -r managingteam-deploy.zip . -x 'node_modules/*' '.git/*' 'vendor/*' 'storage/*.key' '.env' 'managingteam-deploy.zip' 'database/managingteam_celeb.sql'
```

- [ ] **Step 6: Clear bootstrap cache (if 500s)**

```bash
echo '<?php foreach(["../bootstrap/cache/config.php","../bootstrap/cache/packages.php","../bootstrap/cache/services.php","../bootstrap/cache/routes-v7.php","../bootstrap/cache/events.php"] as$f){if(file_exists($f))unlink($f);} foreach(glob("../storage/framework/views/*")as$vf){if(is_file($vf))unlink($vf);} echo "OK"; unlink(__FILE__);' > /tmp/clear-cache.php
curl -s -k -u "managingteam:${CPASS}" -X POST "https://server.ultraprohost.com:2083/execute/Fileman/upload_files" --form "dir=/home/managingteam/public_html/public" --form "overwrite=1" --form "file=@/tmp/clear-cache.php"
curl -s -k -m 30 "https://managingteam.info/clear-cache.php"
```

- [ ] **Step 7: Verify production**

```bash
curl -s -o /dev/null -w "%{http_code}" "https://managingteam.info"
curl -s -o /dev/null -w "%{http_code}" "https://jennie.managingteam.info"
curl -s -o /dev/null -w "%{http_code}" "https://samuel-l-jackson.managingteam.info"
```

Expected: all 200.

- [ ] **Step 8: Clean up deploy artifacts** — delete `managingteam-deploy.zip` locally, remove `/tmp/extract.php` + `/tmp/clear-cache.php` (they self-delete on server).

---
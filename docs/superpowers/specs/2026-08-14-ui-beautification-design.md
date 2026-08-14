# Fan-Facing UI Beautification — "Cinematic Elevation"

**Date**: 2026-08-14
**Status**: Approved (design sign-off in session)

## Goal

Greatly elevate the visual quality of ALL fan-facing UI (guest + logged-in) using the 21st MCP catalog as the design source. Preserve the existing per-celebrity theming system (colors, fonts, page backgrounds, category hero variants) — this is an *elevation* of the current identity, not a replacement. Admin panel (Filament) is explicitly out of scope.

## Design Source

21st MCP catalog components retrieved this session (design language, ported to Blade + Alpine):

1. **Cinematic Landing Hero** (21st id 11494, by easemize) — contributes:
   - Gradient-clipped "matte" headline typography (silver/accent gradient text with drop shadows)
   - Masked radial grid background (`bg-grid-theme`)
   - Film-grain SVG noise overlay
   - Premium depth card with mouse-tracking sheen (`--mouse-x/--mouse-y` CSS vars)
   - Floating glass UI badges
   - Tactile buttons with layered physical shadows + press states
2. **Enterprise Hero Section** (21st id 8156, by uniquesonu) — contributes:
   - Centered badge-pill + headline + subtitle + dual CTAs pattern
   - Trust/social-proof stat row beneath CTAs

**Constraint**: NO GSAP, NO React, NO new npm packages. The cinematic hero's GSAP scroll timeline is replaced with lightweight equivalents: CSS animations + small Alpine.js components (following the existing `card3d()` pattern in `membership-card.blade.php`).

## Design Language (new shared tokens)

All new CSS added to `resources/css/app.css`; Alpine helpers in `resources/js/app.js` (or inline where page-specific).

| Token | Definition |
|-------|-----------|
| `.text-matte` | Accent-gradient clipped text (replaces flat headings on hero) — `linear-gradient(180deg, #fff → accent)` on dark heroes, accent→gold on light sections |
| `.film-grain` | Data-URI SVG noise, `opacity: .05`, `mix-blend-mode: overlay`, `pointer-events: none`, covers hero |
| `.bg-grid-masked` | 60px grid lines in `color-mix(in srgb, var(--accent) 5%, transparent)`, masked with radial-gradient |
| `.depth-card` | Layered shadows (40px/20px/inset highlights) + `--mouse-x/--mouse-y` sheen layer |
| `.btn-tactile` | Enhance `.btn-primary`: layered inner/outer shadows, `translateY(-3px)` hover, press state |
| `x-data="sheenCard"` (Alpine) | Mouse-follow sheen position via rAF, 12fps-friendly direct DOM writes (same discipline as `card3d()`) |

## Page-by-Page Plan (batches)

### Batch 1 — Home page (flagship, design-language carrier)
- `celebrity/partials/hero.blade.php`: all 4 category variants get film-grain + masked grid + matte headline treatment + trust-stats row under CTAs; portrait keeps glow + adds floating glass chips ("3 Membership Tiers" chip stays, plus 1 social chip); mouse-tilt on portrait (Alpine, small angles ≤12°)
- `celebrity/home.blade.php`:
  - Stats bar → keep glass overlap, add count-highlight + matte numbers
  - Gallery → keep bento grid + lightbox, add film-grain hover treatment
  - About → portrait card gets depth-card sheen
  - Features → cards get tactile icon tiles + sheen hover (keep category-specific copy)
  - Tiers → keep BEST SELLER ribbon + price-glow; upgrade card shadow layering
  - Events → keep date-header design; polish shadows
  - Testimonials → keep glass quote cards
  - CTA banner → add film-grain + matte white headline

### Batch 2 — Dashboard + Wallet + Withdraw
- Dashboard: onboarding tracker + stat cards + quick actions get depth-card layering and matte accents; keep all wire:poll/Echo bindings (`data-wallet-balance`, unread badge)
- Wallet: balance card → price-gold + depth; top-up modal + pending deposits + transaction history polish; keep Alpine wallet store bindings
- Withdraw: balance card, request form, accounts sidebar, history badges polish

### Batch 3 — Membership + Meet & Greet + Membership Card + Giveaways
- Membership: tier cards (featured ribbon), subscribe modal (fixed header + scroll body pattern stays), payment-methods component
- Meet & Greet: event cards + purchase modal
- Membership Card: keep 3D gift-card flip (it's already premium), restyle surrounding page (fee banner, redeem form, perks bar)
- Giveaways: prize cards + two-step entry modal (question → payment), "Just for You" badge

### Batch 4 — Messages + Apply + Private Meetup + Custom Page
- Messages: chat-bubble UI polish (bubbles, thread cards, avatars, unread indicators)
- Apply: application form + fee banner + status display
- Private Meetup: pricing table + request form
- Custom page: prose container polish

### Batch 5 — Auth + guest layout
- `layouts/guest.blade.php`: split-screen stays; add film-grain + masked grid + matte wordmark
- `login/register/forgot/reset/confirm/verify`: input groups, glass card, tactile button polish — preserve `url()->current()` form actions and subdomain-only behavior

### Batch 6 — Landing + directory + shared components
- `pages/landing.blade.php`: portal-link entry form as premium hero
- `pages/celebrities.blade.php`: directory table polish
- `livewire/navigation.blade.php`: header (logo, wallet pill, bell) polish — keep all Livewire polling
- `components/footer.blade.php`: polish
- `components/payment-methods.blade.php`: restyle select/file inputs with `.form-input` + tactile buttons — **zero behavior change** (toggle JS untouched)

### Batch 7 — Finalization
- `npm run build`, run all tests (`php artisan test`), `vendor/bin/pint`
- Manual check: Jennie portal (musician), a movie_star portal, country_singer, adult_star hero variants
- Deploy to production (cPanel UAPI zip + extract + cache clear) — ONLY after all batches pass

## Hard Constraints

1. PHP-only stack: Blade + Tailwind v4 + Alpine.js. No React/TSX, no Node runtime, no new packages (GSAP specifically banned)
2. Per-celebrity theming intact: `--accent`, `--accent-secondary`, `--page-bg-*`, fonts — every new utility must use `var(--accent)` or config-driven colors, never hardcoded brand colors
3. Category hero variants (movie_star / country_singer / adult_star / musician) keep their distinct identities — the elevation is additive
4. All existing interactive behavior preserved: payment method toggles (`paymentMethodToggle()`), modal open/close + scroll patterns, gallery lightbox, Echo listeners, Alpine stores (cart/wallet/notifications/ui), Livewire polling, `wire:` bindings, route generation (`route('celebrity.*', ['celebrity' => $slug])`)
5. Inline `<style>`/`<script>` blocks allowed for page-specific effects (layout has no `@stack`)
6. No `json_encode()` on cast attributes; no new DB columns/migrations
7. `x-cloak` CSS stays for Alpine-gated elements

## Testing

- No new backend logic → existing 30 tests must stay green
- Per-batch manual verification of the affected routes on local (jennie.localhost:8000 style setup with `APP_URL=http://localhost:8005`)
- Vite build must pass after each batch

## Out of Scope

- Admin panel (Filament) styling
- New features, new pages, backend changes
- Stripe/queue/Reverb production infrastructure
- The known `Route [login] not defined` wallet-500 bug (pre-existing, tracked separately)

# Boom Warehouse — Factory Launch Commands

## HOW TO RUN THIS

### Step 1: Start Droid in the project
```bash
cd ~/Projects/boom-warehouse && droid
```

### Step 2: Set Auto-Run to HIGH
Press **Shift+Tab** until you see `Auto (High)` in the status bar.
This lets Droid execute commands without asking you to approve each one.

### Step 3: Launch the Mission
Paste this prompt into Droid:

---

```
/missions

Build the complete Boom Warehouse e-commerce site following the PRD at PRD.md.

## CRITICAL CONTEXT — READ THESE FIRST

1. Read PRD.md — this is the master plan. Follow it exactly.
2. Read AGENTS.md — project conventions and compound engineering protocol.
3. Use Serena: read_memory("boom-warehouse/project_state") and read_memory("boom-warehouse/hosting") for hosting details and current state.

## PLATFORM DECISION (ALREADY MADE)

We are building on **WooCommerce** on the existing Hostinger WordPress install. NOT a custom monorepo. NOT Shopify. NOT Medusa. The PRD explains why.

## WHAT TO BUILD (6 MILESTONES)

### Milestone 1: Foundation (WooCommerce Setup)
- Connect boomwarehouse.com DNS via Cloudflare (document the steps, I'll execute DNS changes manually)
- Generate WP-CLI scripts to install and configure WooCommerce
- Install and configure plugins: Stripe Gateway, Yoast SEO, Wordfence
- Configure product categories (TVs, Computers, Appliances, Furniture, Electronics, Household)
- Add custom product attribute: Condition (New / Refurbished / Open Box)
- Configure shipping zones (local pickup + local delivery in Cleveland/Warrensville Heights)
- Configure Ohio sales tax (7.5% Cuyahoga County)
- Set up admin accounts structure

### Milestone 2: Custom Theme + Storefront
- Build custom WooCommerce theme from scratch (NOT a purchased theme)
- Brand: Navy (#1B3A5C) + Orange (#E8792B) + Charcoal (#2D2D2D)
- Warehouse-industrial aesthetic — bold, gritty, textured. NOT generic/clean/corporate.
- Mobile-first responsive (test at 375px, 390px, 768px, 1024px)
- Condition badges: Green pill (New), Blue pill (Refurbished), Amber pill (Open Box)
- Stock indicators: green "In Stock", amber "Low Stock — Only X left", red "Out of Stock"
- Acima CTA: "As low as $XX/mo with Acima" on every eligible product
- Location display: "Available at: Renaissance Pkwy / Emery Rd / Both"
- JSON-LD structured data on product pages
- Sticky "Add to Cart" bar on mobile product pages

### Milestone 3: Products + Acima + Payments
- Install and configure Acima WooCommerce plugin
- Configure Stripe test mode, then provide instructions for live mode switch
- Create CSV import template for bulk product upload
- Create 10 sample products with realistic data across all categories
- Test full checkout flow: browse → cart → Stripe checkout
- Test full Acima flow: browse → cart → Acima lease-to-own checkout
- Set up Cloudflare R2 for image offloading (WP Offload Media plugin)

### Milestone 4: Inventory Management
- Install and configure ATUM Inventory Management for WooCommerce
- Set up two locations: Renaissance Pkwy + Emery Rd
- Configure barcode scanning workflow
- Set reorder points (3 for electronics, 2 for appliances, 5 for accessories)
- Create stock transfer workflow between locations
- Test multi-location stock display on storefront

### Milestone 5: Automation + Operations
- Create docker-compose.yml for n8n on Hostinger VPS
- Build n8n workflows: low-stock alerts, new order notifications, daily sales summary
- Configure WooCommerce transactional emails
- Set up Google Analytics 4
- Set up Google Shopping feed (WooCommerce Google Listings)
- Abandoned cart recovery email workflow

### Milestone 6: Polish + Launch Prep
- Performance audit: WP caching plugin, image optimization, lazy loading
- SEO audit: meta titles/descriptions on all pages, sitemap, robots.txt
- Security hardening: disable XML-RPC, limit login attempts, hide WP version
- Playwright E2E tests for: search→product→cart→checkout, Acima flow
- Create deployment documentation for Hostinger
- Update Serena memory with final state
- Update Obsidian BoomWarehouse.md with launch status

## DROIDS TO USE

Spawn these as subagents where applicable:
- **boom-storefront** — Theme development (Milestone 2)
- **boom-admin** — WooCommerce admin configuration (Milestones 1, 4)
- **boom-infra** — Docker, n8n, deploy scripts (Milestone 5)
- **wordpress-developer** — WooCommerce plugin config, PHP customization
- **frontend-developer** / **frontend-design** — Theme CSS/JS, mobile responsiveness
- **security-sentinel** — Security review after each milestone
- **performance-oracle** — Performance audit at Milestone 6
- **seo-structure-architect** — SEO structure and schema markup
- **test-automator** — Playwright E2E tests

## SKILLS TO USE

- boom-inventory (SKILL.md in .factory/skills/) — domain knowledge for inventory features
- frontend-design — warehouse-industrial aesthetic, NOT generic AI
- vibe-coding — rapid prototyping for theme

## CONSTRAINTS

- All code goes in this repo: ~/Projects/boom-warehouse/
- Theme files go in: wp-content/themes/boom-warehouse/
- WP-CLI scripts go in: scripts/
- n8n config goes in: n8n/
- DO NOT access /Volumes/bp/ — that's another machine
- DO NOT suggest Shopify, Vercel, or any other platform. WooCommerce on Hostinger. Period.
- DO NOT ask me questions. Make decisions and document them. I'll review at milestones.
- Commit after every milestone with conventional commits (feat:, chore:, etc.)
- Update Serena memory after every milestone: write_memory("boom-warehouse/project_state", ...)

## QUALITY GATES PER MILESTONE

Before marking any milestone complete:
1. All code lints clean
2. Theme renders correctly at 375px, 768px, 1024px (if theme exists)
3. No hardcoded secrets — everything in .env
4. Security review passes (no XSS, no SQL injection, no exposed admin)
5. Commit pushed with descriptive message

Start planning now. Break this into features and milestones, then execute.
```

---

## ALTERNATIVE: LFG (Simpler, Single-Agent)

If Missions feels too heavy, use LFG for a single-agent autonomous run:

```bash
cd ~/Projects/boom-warehouse && droid
```

Then set Auto-Run to HIGH (Shift+Tab) and paste:

```
/lfg Build the complete Boom Warehouse e-commerce site. Read PRD.md for the full plan. Follow it phase by phase. WooCommerce on Hostinger, custom theme (Navy/Orange/Charcoal warehouse aesthetic), Stripe + Acima payments, ATUM multi-location inventory, n8n automation. Use all available droids and skills. Don't stop until all 6 phases are complete or you truly can't proceed further. Save state to Serena after each phase.
```

## ALTERNATIVE: SLFG (Swarm — Parallel Agents)

For maximum parallelism using the existing boom-slfg command:

```bash
cd ~/Projects/boom-warehouse && droid
```

Set Auto-Run to HIGH, then:

```
/boom-slfg "Build complete e-commerce platform following PRD.md. WooCommerce on Hostinger, custom warehouse theme, Stripe + Acima, ATUM inventory, n8n automation."
```

## WHICH TO CHOOSE?

| Command | Best For | Parallelism | Cost |
|---------|----------|-------------|------|
| `/missions` | Full build, multi-milestone | Yes (orchestrated) | $$$  (most thorough) |
| `/lfg` | Single focused push | No (one agent) | $$ (moderate) |
| `/boom-slfg` | Parallel droid swarm | Yes (manual swarm) | $$$ (parallel agents) |

**Recommendation:** Start with `/missions`. It plans first, validates at milestones, uses your droids and skills, and you can intervene if it drifts. It's the closest thing to "fire and forget" in Factory.

## BEFORE YOU RUN — CHECKLIST

- [ ] Make sure you're in `~/Projects/boom-warehouse/` (not device_dot_clinic)
- [ ] `git status` should be clean
- [ ] PRD.md exists (we just created it)
- [ ] AGENTS.md exists (it does)
- [ ] Set Auto-Run to HIGH (Shift+Tab until you see it)
- [ ] Have ~$10-20 in Factory credits (missions use multiple agents)

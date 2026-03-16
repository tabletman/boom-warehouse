---
description: "Swarm-enabled LFG for Boom Warehouse. Parallelizes across storefront theme, WooCommerce config, infrastructure, and review agents."
argument-hint: "[feature or milestone description]"
disable-model-invocation: true
---

Swarm-enabled LFG for Boom Warehouse. Run these steps in order, parallelizing where indicated. Do not stop between steps.

## PRE-FLIGHT

0. Read `PRD.md` for the full product requirements. Read `AGENTS.md` for conventions.
1. Use Serena: `read_memory("boom-warehouse/project_state")` and `read_memory("boom-warehouse/hosting")`.

## Sequential Phase

1. `/plan $ARGUMENTS`
2. `/deepen-plan`

## Parallel Build Phase (Swarm Mode)

3. **Launch swarm** — spawn these as parallel Task agents:

**Group A — WooCommerce Application (simultaneous):**
- Task: `boom-storefront` droid — Build/update custom WooCommerce theme per plan
- Task: `wordpress-developer` droid — WooCommerce plugin configuration, WP-CLI scripts, Acima + Stripe setup
- Task: `boom-admin` droid — WooCommerce admin config, ATUM inventory setup, product import

**Group B — Infrastructure (simultaneous):**
- Task: `boom-infra` droid — n8n Docker config, Cloudflare R2 setup, deploy scripts for Hostinger
- Task: general-purpose subagent — SEO setup (Yoast config, JSON-LD, sitemap), GA4, Google Shopping feed

Wait for all Group A + B tasks to complete before continuing.

## Parallel Review Phase

4. Launch these as **parallel review agents**:
   - `security-sentinel` — WordPress hardening, XSS, SQL injection, exposed admin
   - `performance-oracle` — Core Web Vitals, caching, image optimization
   - `code-simplicity-reviewer` — YAGNI check on theme code
   - `seo-structure-architect` — Schema markup, meta tags, URL structure

Wait for all reviews to complete.

## Finalize Phase

5. Resolve findings from all reviewers
6. Run Playwright E2E tests: search → product → cart → Stripe checkout, Acima checkout flow
7. Final synthesis review
8. Update Serena: `write_memory("boom-warehouse/project_state", "...")`
9. Update Obsidian: `~/Library/Mobile Documents/iCloud~md~obsidian/Documents/kN0x/LCP/Projects/BoomWarehouse.md`
10. Output `<promise>DONE</promise>` when all reviews pass and tests green

Start with step 0 now.

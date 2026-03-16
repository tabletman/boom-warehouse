# Hermes Prompt — Boom Warehouse PRD Generation

> Copy-paste this into a Hermes chat session.
> Run: `cd ~/Projects/boom-warehouse && hermes chat`

---

## The Prompt

```
Generate a complete PRD for Boom Warehouse and save it to /Users/perks/Projects/boom-warehouse/PRD.md

### PATH CONSTRAINTS — CRITICAL

You MUST only read/write files under:
- /Users/perks/Projects/boom-warehouse/
- ~/Library/Mobile Documents/iCloud~md~obsidian/Documents/kN0x/LCP/Projects/BoomWarehouse.md

DO NOT access /Volumes/bp/ or any network volumes. They are on another machine and will fail or return stale data. Everything you need is in the paths above.

### USE YOUR MEMORY

1. Query Honcho first: `query_user_context("What do I know about Brian's Boom Warehouse project, his preferences, and his budget?")`
2. Read these files in the repo:
   - PRD-PROMPT.md (project brief and droid army)
   - AGENTS.md (conventions, architecture notes, phase plan)
3. After generating the PRD, save key decisions to memory for future sessions.

### PLATFORM DECISION — EVALUATE HONESTLY

The existing AGENTS.md assumes a custom monorepo (Next.js + Fastify + Drizzle). DO NOT blindly follow that assumption. Instead, evaluate these options and RECOMMEND the best one in the PRD:

**Option A: WooCommerce on existing WordPress**
- Hostinger already has WordPress installed
- WooCommerce is free, massive plugin ecosystem
- Acima has a WooCommerce plugin
- Zero infrastructure to build — just configure
- Downside: PHP, limited customization, plugin dependency

**Option B: Medusa.js (open-source headless e-commerce)**
- Node.js native, Hostinger supports Node
- Headless = custom storefront with Next.js
- Built-in inventory, orders, payments, admin
- Downside: more setup than WooCommerce, smaller ecosystem

**Option C: Custom monorepo (current plan)**
- Next.js 15 + Fastify 5 + Drizzle + PostgreSQL
- Maximum flexibility, zero platform lock-in
- Downside: months of work, every feature built from scratch

**Option D: Shopify Lite + custom storefront**
- Shopify handles payments, inventory, Acima
- Custom Next.js frontend via Storefront API
- Downside: monthly Shopify fee on top of Hostinger

Pick the option that gets a working store live fastest with the least ongoing maintenance, given:
- Client already paid for Hostinger (Business Web Hosting plan with Node.js support)
- Budget is tight (~$38/mo operational max)
- Brian wants the agent (you) to build it autonomously without him installing things manually
- Acima lease-to-own integration is a MUST (it's a key business differentiator)
- Two physical locations need inventory tracking
- Mobile-first (60%+ mobile traffic)

### PRD STRUCTURE

1. **Executive Summary** — business, problem, solution, recommended platform
2. **Platform Decision** — comparison table of all 4 options with pros/cons/cost/timeline, then the recommendation with reasoning
3. **Business Context** — two locations (4554 Renaissance Pkwy Warrensville Heights + 26055 Emery Rd B-1 Cleveland), product categories, Acima financing
4. **User Personas** — customer, warehouse staff, owner
5. **Core Features** (prioritized by business value):
   - Product catalog with condition grades (New/Refurbished/Open Box)
   - Shopping cart + checkout (Stripe + Acima)
   - Product search
   - Inventory management (multi-location, barcode scanning, stock alerts)
   - Admin dashboard (orders, fulfillment, reporting)
   - Customer accounts
6. **Technical Architecture** — based on the recommended platform, not the rejected ones
7. **Hosting & Deployment** — Hostinger Cloud ONLY (not Vercel, not Fly.io, not AWS). Docker Compose if needed. Cloudflare CDN.
8. **Design Direction** — Navy (#1B3A5C) + Orange (#E8792B) + Charcoal (#2D2D2D), warehouse-industrial, mobile-first
9. **API/Integration Surface** — whatever the chosen platform exposes
10. **Data Model** — Mermaid ERD
11. **Quality Gates** — performance targets, testing strategy
12. **Phase Plan** — realistic timeline to get to a live, working store
13. **Risks & Mitigations**
14. **Success Metrics**

### FORMAT
- Single Markdown document with table of contents
- Mermaid diagrams for architecture and data model
- Detailed enough that a developer unfamiliar with the project can start building

### DO NOT
- Assume custom is the only option
- Suggest Vercel for hosting
- Read from /Volumes/bp/
- Generate application code (this is a planning doc)
- Create files outside /Users/perks/Projects/boom-warehouse/
```

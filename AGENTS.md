# Boom Warehouse — Agent Guidelines
> Factory.ai AGENTS.md — read at every session start.
> Product: Boom Warehouse | Repo: tabletman/boom-warehouse
> OBSIDIAN SOURCE OF TRUTH: `~/Library/Mobile Documents/iCloud~md~obsidian/Documents/kN0x/LCP/Projects/BoomWarehouse.md`

## SESSION START PROTOCOL (MANDATORY)

Before ANY work:

1. **Serena**: `read_memory("project_state")` and `read_memory("repo_patterns")`
2. `git status` + `git log --oneline -5`
3. Tell the user: "Serena says we are at [phase]. What compound engineering step are we on?"
4. Check Obsidian note for latest state

## COMPOUND ENGINEERING (GATES ALL DEVELOPMENT)

```
Step 1: PLAN     → what are we building?
Step 2: WORK     → execute with task tracking
Step 3: REVIEW   → multi-agent review before merge
Step 4: COMPOUND → document learnings, update Serena + Obsidian
```

No code without a plan. No merge without review. No feature without compounding.

## What This Project Is

Production e-commerce platform and inventory management system for Boom Warehouse — a Cleveland-area refurbished electronics and appliance retailer. Two physical locations in Warrensville Heights and Cleveland, OH. Acima lease-to-own financing.

**Current site**: boomwarehouse.com (non-functional)
**Target**: Full e-commerce + warehouse IMS + admin dashboard

## Architecture

Monorepo with turborepo:
```
apps/storefront/    → Next.js 15 customer-facing store
apps/admin/         → Next.js 15 warehouse staff dashboard
apps/api/           → Fastify 5 REST API
packages/db/        → Drizzle ORM schema + migrations
packages/shared/    → Zod schemas, types, utilities
packages/config/    → Shared eslint, tsconfig
```

## Stack
| Layer | Tech |
|-------|------|
| Frontend | Next.js 15, React 19, Tailwind CSS, Framer Motion |
| Admin | Next.js 15, shadcn/ui, Recharts, quagga2 (barcode) |
| API | Fastify 5, TypeScript strict, Zod validation |
| Database | PostgreSQL 16 via Drizzle ORM |
| Cache | Redis 7 |
| Search | Meilisearch v1.7 |
| Auth | Auth.js v5 (JWT) |
| Payments | Stripe + Acima lease-to-own |
| Storage | Cloudflare R2 + CDN |
| Automation | n8n (self-hosted) |
| Hosting | Hostinger Cloud Enterprise + VPS |

## Non-Negotiables
- TypeScript strict mode, zero `any`
- Zod validation on all API boundaries
- 80%+ test coverage (Vitest + Playwright + Supertest)
- Core Web Vitals: LCP < 2.5s, CLS < 0.1, INP < 200ms
- Mobile-first responsive
- No secrets in code — environment variables only
- Conventional commits (feat:, fix:, chore:)

## Design
- Palette: Navy (#1B3A5C) + Orange (#E8792B) + Charcoal (#2D2D2D)
- Bold, warehouse-industrial aesthetic — NOT generic AI aesthetics
- Product photography + clear pricing prominence
- Condition badges (New/Refurbished/Open Box) + stock indicators

## Custom Droids (4)
boom-storefront, boom-inventory-api, boom-admin, boom-infra

## Running
```bash
docker compose up -d    # Full stack
npm run dev             # Dev mode (after monorepo setup)
```

## Phase Plan
- Phase 0: Repo setup, git, Serena, compound engineering — IN PROGRESS
- Phase 1: Monorepo scaffold, DB schema, API skeleton
- Phase 2: Storefront (product listing, cart, checkout)
- Phase 3: Admin dashboard (inventory, orders, barcode)
- Phase 4: Payments (Stripe + Acima), Auth
- Phase 5: Search, performance, deploy to Hostinger

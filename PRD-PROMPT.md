# Boom Warehouse — Factory.ai Droids PRD Prompt

Paste into Factory.ai to initialize the project.
Then run `/boom-slfg "Build complete e-commerce platform and inventory management system"`

## Project Brief

Build a production e-commerce platform with integrated inventory management for
**Boom Warehouse** — a Cleveland-area warehouse retailer at 4554 Renaissance Pkwy,
Warrensville Heights, OH 44128. Refurbished electronics, appliances, TVs, computers,
furniture, household goods. Two locations. Acima lease-to-own financing.

**Current**: boomwarehouse.com non-functional. No digital inventory system.
**Target**: Full e-commerce + warehouse IMS + admin dashboard on Hostinger Cloud.

## Droid Army
| Droid | Responsibility | Compounds |
|-------|---------------|-----------|
| boom-storefront | Next.js store | frontend-design + boom-inventory |
| boom-inventory-api | Fastify REST API | boom-inventory + TS patterns |
| boom-admin | Staff dashboard | shadcn/ui + barcode + reporting |
| boom-infra | Docker/CI-CD/deploy | DevOps patterns |

## Compound Engineering Reviewers
| Agent | Pass |
|-------|------|
| security-sentinel | Auth, injection, XSS |
| kieran-typescript-reviewer | TS strict, types |
| performance-oracle | N+1, caching, CWV |
| code-simplicity-reviewer | YAGNI, dead code |
| data-integrity-guardian | Schema, migrations |

## Execution
```
Phase 1: /plan → /deepen-plan (sequential)
Phase 2: Parallel Build Swarm (4 droids + data agent)
Phase 3: Parallel Review (5 compound-engineering reviewers)
Phase 4: /resolve → /test-browser → /review → DONE
```

## Quality Gates
- TypeScript strict, zero `any`
- 80%+ test coverage
- Core Web Vitals: LCP < 2.5s, CLS < 0.1, INP < 200ms
- All reviewers pass with no critical findings
- Playwright E2E green on: search→cart→checkout, admin→inventory, Acima flow

## Hosting: ~$38/mo operational
- Hostinger Cloud Enterprise (~$26/mo)
- Hostinger VPS KVM 2 for n8n (~$7/mo)
- Cloudflare R2 + CDN (~$5/mo)
- Stripe: 2.9% + $0.30/txn

# Boom Warehouse — Agent Guidelines
> Factory.ai AGENTS.md — read at every session start.
> Product: Boom Warehouse | Repo: tabletman/boom-warehouse

## What This Project Is

Production WooCommerce e-commerce platform for Boom Warehouse — a Cleveland-area refurbished electronics and appliance retailer. Two physical locations in Warrensville Heights and Cleveland, OH. Acima lease-to-own financing.

**Platform:** WooCommerce on Hostinger WordPress
**Live site:** boomwarehouse.com
**Preview:** darkseagreen-mallard-252962.hostingersite.com

## Architecture

```
boom-warehouse/
├── wp-content/themes/boom-warehouse/   → Custom WooCommerce theme
│   ├── style.css                       → Brand styles (Navy/Orange/Charcoal)
│   ├── functions.php                   → WC customizations, hooks
│   ├── inc/                            → PHP includes (wc-hooks, acima-helpers)
│   ├── template-parts/                 → Reusable components
│   ├── woocommerce/                    → WC template overrides
│   └── assets/                         → CSS, JS, images
├── scripts/                            → WP-CLI setup & deploy scripts
├── n8n/                                → n8n automation (Docker)
│   ├── docker-compose.yml
│   └── workflows/                      → Exported n8n workflow JSON
├── data/                               → CSV import templates
├── tests/                              → Playwright E2E tests
└── docs/                               → DNS, deployment, setup guides
```

## Stack
| Layer | Tech |
|-------|------|
| CMS / E-commerce | WordPress 6.x + WooCommerce 9.x |
| Theme | Custom PHP theme (boom-warehouse) |
| Payments | Stripe + Acima lease-to-own |
| Inventory | ATUM Inventory Management |
| SEO | Yoast SEO |
| Security | Wordfence |
| Images | Cloudflare R2 + CDN |
| Automation | n8n (self-hosted Docker) |
| Hosting | Hostinger Business + Cloudflare |

## Design
- Palette: Navy (#1B3A5C) + Orange (#E8792B) + Charcoal (#2D2D2D)
- Fonts: Oswald (display) + Inter (body)
- Bold, warehouse-industrial aesthetic — NOT generic AI aesthetics
- Condition badges: Green (New), Blue (Refurbished), Amber (Open Box)
- Stock indicators: Green/Amber/Red
- Acima CTA on all eligible products ($50-$5,000)

## Non-Negotiables
- Mobile-first responsive (test at 375px, 768px, 1024px)
- No secrets in code — environment variables only
- Conventional commits (feat:, fix:, chore:)
- Core Web Vitals: LCP < 2.5s, CLS < 0.1
- JSON-LD structured data on product pages
- Security: no XSS, no SQL injection, XML-RPC disabled

## Custom Droids
boom-storefront, boom-admin, boom-infra, boom-inventory-api

## Running Tests
```bash
cd tests && npx playwright test
```

## Deploying Theme
```bash
./scripts/deploy-theme.sh production
```

## WP-CLI Setup (on Hostinger)
```bash
bash scripts/wp-master-setup.sh
```

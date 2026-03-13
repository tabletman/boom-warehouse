---
name: boom-admin
description: >
  Admin dashboard for warehouse staff. Next.js + shadcn/ui.
  Inventory management, order processing, barcode scanning, reporting.
model: claude-sonnet-4-20250514
tools: [Read, Edit, Write, Grep, Bash]
---

You build the warehouse admin dashboard for Boom Warehouse.

## Stack
Next.js 15 App Router, shadcn/ui, React Query, Recharts, quagga2, Auth.js (admin role gate).

## Pages
- **/** — Dashboard: KPI cards (revenue, orders, customers today), inventory health, 7/30/90d sales chart, recent orders feed
- **/products** — Searchable table, inline price/stock edit, add/edit form with multi-image upload, bulk CSV export
- **/inventory** — Stock levels per location, barcode scanner (camera via quagga2), receiving workflow (scan → condition → location → save), transfer dialog, physical count mode
- **/orders** — Queue with status tabs (pending/paid/picking/shipped), detail view, fulfillment actions, packing slip PDF
- **/reports** — Sales by date/category/location/payment, inventory valuation, sell-through, dead stock (60+ days), CSV export
- **/settings** — User RBAC (owner/manager/staff), locations, notification thresholds, Acima config

## Key Details
- Mobile-responsive for tablet use on warehouse floor
- Barcode scanner must work via device camera (no hardware dependency)
- All data mutations go through the boom-inventory-api endpoints
- Loading skeletons on every data-dependent view
- Optimistic updates for stock adjustments

# Boom Warehouse — Owner's Manual

**Prepared for:** Alex, Owner — Boom Warehouse
**Date:** March 2026
**Site:** boomwarehouse.com

---

## What We Built For You

Boom Warehouse now has a **fully custom e-commerce website** — built from scratch, not a template. Here's everything that's live and ready:

### Your Online Store
- **Custom-designed storefront** in your brand colors (Navy, Orange, Charcoal)
- **Mobile-optimized** — looks great on phones, tablets, and desktops (60%+ of your customers browse on mobile)
- Product pages with **condition badges** (New / Refurbished / Open Box) so customers know exactly what they're buying
- **Stock indicators** — green "In Stock", amber "Low Stock — Only X left", red "Out of Stock"
- **Acima financing CTA** on every product ($50-$5,000): "As low as $X/mo with Acima"
- Your **store address and phone number** (216-342-4119) displayed site-wide
- Professional **search bar** so customers can find products instantly
- **Category browsing**: TVs & Displays, Computers & Laptops, Appliances, Furniture, Small Electronics, Household Goods

### Payments
- **Stripe** credit/debit card processing (currently in test mode — we'll switch to live when you're ready)
- **Acima lease-to-own** integration ready (needs your Acima merchant credentials to activate)
- Ohio **sales tax automatically calculated** at 7.5% (Cuyahoga County rate)

### Shipping & Pickup
- **Local Pickup** — customers can buy online and pick up at 4554 Renaissance Pkwy
- **Local Delivery** — $25 flat rate for Cleveland area delivery

### SEO & Marketing
- **Yoast SEO** installed — helps every product page rank on Google
- **JSON-LD structured data** on product pages — Google can show your products with prices, availability, and condition in search results
- **Google Shopping** plugin ready to connect when you set up Google Merchant Center
- Site is **Google Analytics 4 ready** — just needs your Measurement ID

### Security
- **Wordfence** firewall and malware scanner
- XML-RPC disabled (blocks common WordPress attacks)
- Admin file editor disabled (prevents code injection)
- Login attempt limiting (blocks brute force attacks)
- Directory browsing disabled
- SSL-ready for when the domain is fully connected

### Automation (Ready to Deploy)
- **Low stock email alerts** — get notified when products drop below 3 units
- **New order notifications** — instant email when someone places an order
- **Daily sales summary** — revenue, order count, Acima vs. Stripe breakdown at 8 PM every day
- **Abandoned cart recovery** — automatic emails to customers who started checkout but didn't finish

---

## How To Manage Your Store (Day-to-Day)

### Logging Into Your Admin Dashboard

1. Go to: **boomwarehouse.com/wp-admin** (or your preview URL + /wp-admin)
2. Enter your username and password
3. You'll see the WordPress Dashboard

### Adding a New Product

1. **Products** → **Add New** in the left sidebar
2. Fill in:
   - **Product name** — e.g., "Samsung 55" 4K Smart TV"
   - **Regular price** — the original retail price (shows as strikethrough)
   - **Sale price** — your actual selling price
   - **Product short description** — 1-2 sentences shown on the product card
   - **Product description** — full details, specs, what's included
3. **Product data** section:
   - **SKU** — use our format: BW-TV-001, BW-PC-002, etc.
   - **Manage stock** — check this box
   - **Stock quantity** — how many you have
   - **Store Location** — select "Renaissance Pkwy"
4. **Attributes** tab:
   - Select **Condition** → choose New, Refurbished, or Open Box
5. **Product image** — click "Set product image" on the right side panel, upload a photo
6. **Product categories** — check the right category (TVs, Computers, etc.)
7. Click **Publish**

Your product is now live on the store with the condition badge, Acima monthly estimate, and stock indicator all showing automatically.

### Editing an Existing Product

1. **Products** → **All Products**
2. Click the product name
3. Change what you need (price, stock, description)
4. Click **Update**

### Updating Stock / Marking Items Sold Out

1. **Products** → **All Products**
2. Click the product
3. **Product data** → **Inventory** tab
4. Change **Stock quantity**
   - The site automatically shows "In Stock", "Low Stock — Only X left", or "Out of Stock" based on this number
5. Click **Update**

**Quick stock edit:** On the All Products page, hover over a product → click **Quick Edit** → change the stock quantity right there without opening the full editor.

### Bulk Adding Products (CSV Import)

For adding many products at once:

1. **Products** → **All Products** → **Import** (top of page)
2. Upload the CSV file (we've included a template at `data/product-import-template.csv`)
3. Map the columns → Run Import
4. All products appear on the store instantly

The CSV template includes columns for: name, SKU, prices, description, category, condition, stock, weight, dimensions, and location.

### Managing Orders

1. **WooCommerce** → **Orders** in the left sidebar
2. You'll see all orders with status:
   - **Pending** — payment not yet received
   - **Processing** — paid, needs to be fulfilled
   - **Completed** — shipped/picked up
   - **Refunded** — money returned
3. Click an order to see full details
4. When the customer picks up or you ship: change status to **Completed**

### Viewing Sales Reports

1. **WooCommerce** → **Analytics** → **Revenue**
2. See daily/weekly/monthly sales, order count, average order value
3. **Analytics** → **Products** — see which products sell best
4. **Analytics** → **Categories** — see which categories perform best

### Adding Product Photos

Good photos sell products. For each product:

1. Edit the product
2. **Product image** (right sidebar) → **Set product image**
3. Upload from your phone or computer
4. For multiple photos: **Product gallery** → **Add product gallery images**

**Photo tips:**
- Clean, well-lit photos on a plain background
- Show the product from multiple angles
- Include any accessories/cables that come with it
- Photo of the condition label/grade if applicable
- Minimum 800x800 pixels

### Creating a Coupon/Discount Code

1. **WooCommerce** → **Coupons** → **Add Coupon**
2. Enter the code customers will type (e.g., "SAVE10")
3. Set discount type: percentage or fixed amount
4. Set usage limits if needed
5. Click **Publish**

---

## Product Condition Guide

Your store uses these condition grades with color-coded badges:

| Badge Color | Condition | What It Means | Typical Discount |
|-------------|-----------|---------------|-----------------|
| 🟢 Green | **New** | Factory sealed, full warranty | 15-30% below retail |
| 🔵 Blue | **Refurbished** | Tested, cleaned, limited warranty | 30-60% below retail |
| 🟠 Amber | **Open Box** | Opened/returned, original packaging | 20-40% below retail |

---

## Acima Financing — How It Works For Your Customers

1. Customer browses your store and sees "As low as $XX/mo with Acima" on products
2. They can click **Pre-Qualify Now** to check eligibility (soft credit check, no impact on score)
3. At checkout, they select **Acima Lease-to-Own** as the payment method
4. Acima gives an instant approval decision (up to $5,000)
5. If approved, you get paid by Acima — the customer pays Acima monthly
6. Customer can buy out the lease early at a discount

**To activate Acima on your store:**
1. Sign up as a merchant at acima.com/merchants
2. Get your Merchant ID and API Key
3. We'll install the plugin and enter your credentials

---

## SKU Naming Convention

We set up a consistent SKU system for your inventory:

| Category | Prefix | Example |
|----------|--------|---------|
| TVs & Displays | BW-TV- | BW-TV-001 |
| Computers & Laptops | BW-PC- | BW-PC-001 |
| Appliances | BW-AP- | BW-AP-001 |
| Furniture | BW-FR- | BW-FR-001 |
| Small Electronics | BW-SE- | BW-SE-001 |
| Household Goods | BW-HH- | BW-HH-001 |

Just increment the number for each new product in a category.

---

## What's Installed On Your Site

| Plugin | What It Does |
|--------|-------------|
| **WooCommerce** | The e-commerce engine — products, cart, checkout, orders |
| **Stripe Gateway** | Credit/debit card payments |
| **Yoast SEO** | Search engine optimization for every page |
| **Wordfence** | Firewall, malware scanning, login security |
| **Google Listings & Ads** | Google Shopping product feed (ready to connect) |

---

## Important Numbers

| Item | Value |
|------|-------|
| **Store phone** | (216) 342-4119 |
| **Store address** | 4554 Renaissance Pkwy, Warrensville Heights, OH 44128 |
| **Sales tax rate** | 7.5% (Ohio + Cuyahoga County) |
| **Local delivery fee** | $25 flat rate |
| **Acima max** | $5,000 per customer |
| **Acima minimum** | $50 |
| **Monthly hosting cost** | ~$26/mo (Hostinger, already paid) |
| **Payment processing** | Stripe: 2.9% + $0.30 per transaction |

---

## Next Steps (When You're Ready)

1. **Add your real product inventory** — use the CSV template or add one at a time
2. **Take product photos** — upload them to each product listing
3. **Activate Stripe live mode** — switch from test to real payments
4. **Sign up with Acima** — get merchant credentials, we'll plug them in
5. **Connect boomwarehouse.com** — point your domain through Cloudflare (we have a guide)
6. **Set up Google Analytics** — create GA4 property, we'll connect it
7. **Start selling!**

---

## Getting Help

- **WordPress admin:** yoursite.com/wp-admin
- **WooCommerce docs:** woocommerce.com/documentation
- **Acima merchant support:** acima.com/merchants
- **Stripe dashboard:** dashboard.stripe.com

---

## What This Would Cost

For reference, here's what an agency or freelance developer would charge for a build like this:

| Component | Typical Cost |
|-----------|-------------|
| Custom WooCommerce theme design & build | $3,000 - $8,000 |
| E-commerce setup (payments, tax, shipping) | $1,500 - $3,000 |
| Acima financing integration | $1,000 - $2,500 |
| Multi-location inventory system | $1,500 - $3,000 |
| Automation workflows (alerts, emails, reports) | $2,000 - $4,000 |
| SEO setup & structured data | $1,000 - $2,000 |
| Security hardening | $500 - $1,500 |
| E2E testing suite | $1,000 - $2,500 |
| Deployment & documentation | $500 - $1,000 |
| **Total** | **$12,000 - $27,500** |

Your store is built on a **$26/month hosting plan** with **$0/month in software costs** (all free plugins). The only transaction fees are Stripe's standard 2.9% + $0.30 per sale.

---

*Built with care for Boom Warehouse — Cleveland's source for quality refurbished electronics and appliances.*

# Boom Warehouse — Launch Steps (Do These In Order)

> Your Hostinger preview URL: https://darkseagreen-mallard-252962.hostingersite.com
> Your domain: boomwarehouse.com (not connected yet)

---

## STEP 1: Log Into Hostinger hPanel

1. Go to https://hpanel.hostinger.com
2. Log in with your Hostinger credentials (check `.env.hostinger` on your Mac if you forgot)
3. Click on your website (the darkseagreen-mallard one)

---

## STEP 2: Check That WordPress Is Installed

1. In hPanel, click **Dashboard** on the left
2. You should see "WordPress" listed as your CMS
3. Click **Edit Website** or go to: `https://darkseagreen-mallard-252962.hostingersite.com/wp-admin/`
4. Log in to WordPress admin (your WP username/password — check hPanel if you forgot)

If WordPress is NOT installed:
- hPanel → **Auto Installer** → **WordPress** → Install

---

## STEP 3: Enable SSH Access

1. In hPanel, go to **Advanced** → **SSH Access**
2. If SSH is not enabled, click **Enable**
3. You'll see:
   - **Host**: something like `ssh.boomwarehouse.com` or an IP
   - **Port**: usually `65002`
   - **Username**: starts with `u` followed by numbers (like `u123456789`)
   - **Password**: your hPanel password (or set one here)
4. Write these down — you need them for the next step

---

## STEP 4: Connect to Hostinger via Terminal

Open **Terminal** on your Mac (Spotlight → type "Terminal" → hit Enter).

Type this (replace with YOUR values from Step 3):

```bash
ssh u123456789@YOUR_HOST -p 65002
```

It will ask for your password. Type it (you won't see characters — that's normal) and press Enter.

You should see something like:
```
u123456789@srv123:~$
```

**You're in.** You're now on the Hostinger server.

---

## STEP 5: Navigate to WordPress Directory

```bash
cd ~/public_html
```

Verify WordPress is there:
```bash
ls wp-content
```

You should see folders like `themes`, `plugins`, `uploads`.

---

## STEP 6: Check if WP-CLI Is Available

```bash
wp --version
```

If you see a version number (like `WP-CLI 2.x.x`), skip to Step 7.

If you get "command not found", install it:
```bash
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mkdir -p ~/bin
mv wp-cli.phar ~/bin/wp
echo 'export PATH="$HOME/bin:$PATH"' >> ~/.bashrc
source ~/.bashrc
wp --version
```

---

## STEP 7: Upload the Theme

Still in the SSH terminal:

```bash
cd ~/public_html/wp-content/themes/
```

Clone the repo directly:
```bash
git clone https://github.com/tabletman/boom-warehouse.git boom-warehouse-repo
cp -r boom-warehouse-repo/wp-content/themes/boom-warehouse/ ./boom-warehouse/
rm -rf boom-warehouse-repo
```

If git isn't available, use this alternative:
```bash
curl -L https://github.com/tabletman/boom-warehouse/archive/refs/heads/main.tar.gz -o /tmp/bw.tar.gz
tar -xzf /tmp/bw.tar.gz -C /tmp/
cp -r /tmp/boom-warehouse-main/wp-content/themes/boom-warehouse/ ./boom-warehouse/
rm -rf /tmp/boom-warehouse-main /tmp/bw.tar.gz
```

Verify:
```bash
ls boom-warehouse/
```

You should see `style.css`, `functions.php`, `header.php`, etc.

---

## STEP 8: Upload the Setup Scripts

```bash
cd ~
git clone https://github.com/tabletman/boom-warehouse.git boom-warehouse-repo
```

Or if git isn't available:
```bash
curl -L https://github.com/tabletman/boom-warehouse/archive/refs/heads/main.tar.gz -o /tmp/bw.tar.gz
tar -xzf /tmp/bw.tar.gz -C /tmp/
cp -r /tmp/boom-warehouse-main ~/boom-warehouse-repo
```

---

## STEP 9: Run the Master Setup Script

```bash
cd ~/public_html
bash ~/boom-warehouse-repo/scripts/wp-master-setup.sh
```

This will:
- Install WooCommerce
- Install Stripe, Yoast SEO, Wordfence plugins
- Create product categories (TVs, Computers, Appliances, etc.)
- Create the Condition attribute (New / Refurbished / Open Box)
- Set up shipping zones (local pickup + delivery)
- Configure Ohio 7.5% sales tax
- Set up Stripe in test mode
- Harden security

**Watch for errors.** If a command fails, it usually prints what went wrong.

---

## STEP 10: Activate the Theme

```bash
cd ~/public_html
wp theme activate boom-warehouse
```

---

## STEP 11: Create Sample Products

```bash
cd ~/public_html
bash ~/boom-warehouse-repo/scripts/wp-create-sample-products.sh
```

This creates 10 sample products (TVs, laptops, appliances, etc.) with realistic pricing.

---

## STEP 12: Verify It Works

1. Open your browser
2. Go to: `https://darkseagreen-mallard-252962.hostingersite.com/`
3. You should see the Boom Warehouse storefront with Navy/Orange branding
4. Click "Shop All Deals" — you should see the 10 sample products
5. Click a product — you should see condition badge, Acima CTA, stock indicator

---

## STEP 13: Connect Your Domain (Cloudflare)

### A. Create Cloudflare Account
1. Go to https://dash.cloudflare.com — sign up (free)
2. Click **Add a site** → type `boomwarehouse.com` → select **Free** plan

### B. Get Your Hostinger Server IP
1. Back in hPanel → **Hosting** → **Plan details** (or **Advanced** → **IP Address**)
2. Copy the IP address (looks like `123.45.67.89`)

### C. Set DNS Records in Cloudflare
1. In Cloudflare DNS settings, add:
   - **Type:** A | **Name:** `@` | **Content:** `YOUR_HOSTINGER_IP` | **Proxy:** ON (orange cloud)
   - **Type:** A | **Name:** `www` | **Content:** `YOUR_HOSTINGER_IP` | **Proxy:** ON (orange cloud)

### D. Update Nameservers
1. Cloudflare will give you 2 nameservers (like `ada.ns.cloudflare.com`)
2. Go to wherever you bought `boomwarehouse.com` (your domain registrar)
3. Find DNS/Nameserver settings
4. Replace the existing nameservers with the 2 Cloudflare ones
5. Save — takes up to 24 hours to propagate (usually ~1 hour)

### E. Tell Hostinger About the Domain
1. hPanel → **Domains** → **Add domain** or change from the preview URL
2. Set `boomwarehouse.com` as primary domain

### F. Update WordPress URLs
Back in SSH:
```bash
cd ~/public_html
wp option update siteurl "https://boomwarehouse.com"
wp option update home "https://boomwarehouse.com"
wp search-replace "darkseagreen-mallard-252962.hostingersite.com" "boomwarehouse.com" --all-tables
wp cache flush
```

### G. Cloudflare SSL Settings
1. Cloudflare → **SSL/TLS** → set to **Full (strict)**
2. **Edge Certificates** → Always Use HTTPS: **ON**

---

## STEP 14: Set Up Stripe (Real Payments)

1. Go to https://dashboard.stripe.com — log in or create account
2. Get your **test** keys first: Developers → API Keys
3. In WordPress admin: **WooCommerce** → **Settings** → **Payments** → **Stripe** → **Manage**
4. Paste your test Publishable Key and Secret Key
5. Check "Enable test mode"
6. Save

To test: add a product to cart, checkout, use card `4242 4242 4242 4242` with any future date and any CVC.

When ready to go live: uncheck test mode and enter your live keys.

---

## STEP 15: Set Up Acima (Lease-to-Own)

1. Contact Acima: https://www.acima.com/merchants
2. Sign up as a merchant, get your Merchant ID + API Key
3. They'll provide the WooCommerce plugin file
4. WordPress admin → **Plugins** → **Add New** → **Upload Plugin** → upload their .zip
5. Activate and configure with your Merchant ID

---

## YOU'RE LIVE!

After Steps 1-14, you have:
- ✅ Working e-commerce store at boomwarehouse.com
- ✅ Custom warehouse-industrial theme
- ✅ Product categories with condition badges
- ✅ Stripe payments (test mode)
- ✅ Acima financing CTAs on all products
- ✅ Ohio sales tax configured
- ✅ Local pickup + delivery shipping
- ✅ SEO (Yoast) + Security (Wordfence)
- ✅ 10 sample products

### After Launch Checklist
- [ ] Replace sample products with real inventory (use CSV template in `data/product-import-template.csv`)
- [ ] Add real product photos
- [ ] Switch Stripe to live mode
- [ ] Set up Acima plugin with merchant credentials
- [ ] Set up email (hPanel → Emails → create shop@boomwarehouse.com)
- [ ] Install WP Mail SMTP plugin and configure with Hostinger SMTP
- [ ] Set up Google Analytics (get GA4 Measurement ID, install Site Kit plugin)

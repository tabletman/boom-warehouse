# Boom Warehouse — DNS & Cloudflare Setup

## Prerequisites
- Cloudflare account (free tier)
- Access to domain registrar for boomwarehouse.com
- Hostinger hPanel access

## Step 1: Add Domain to Cloudflare

1. Log in to [Cloudflare Dashboard](https://dash.cloudflare.com)
2. Click "Add a site" → enter `boomwarehouse.com`
3. Select **Free** plan
4. Cloudflare will scan existing DNS records

## Step 2: Update Nameservers

At your domain registrar, change nameservers to the ones Cloudflare provides (e.g.):
```
ns1.cloudflare.com  (example — use YOUR assigned nameservers)
ns2.cloudflare.com
```

Wait for propagation (up to 24 hours, usually < 1 hour).

## Step 3: Configure DNS Records

In Cloudflare DNS settings, create:

| Type | Name | Content | Proxy | TTL |
|------|------|---------|-------|-----|
| A | `@` | `<Hostinger Server IP>` | Proxied (orange) | Auto |
| A | `www` | `<Hostinger Server IP>` | Proxied (orange) | Auto |
| CNAME | `www` | `boomwarehouse.com` | Proxied (orange) | Auto |

**Get Hostinger IP:** hPanel → Hosting → your site → Server IP (or Advanced → IP address)

## Step 4: SSL/TLS Configuration

In Cloudflare:
1. **SSL/TLS → Overview** → Set to **Full (strict)**
2. **SSL/TLS → Edge Certificates** → Enable:
   - Always Use HTTPS: ON
   - Automatic HTTPS Rewrites: ON
   - Minimum TLS Version: TLS 1.2

## Step 5: Cloudflare Settings

**Speed → Optimization:**
- Auto Minify: HTML, CSS, JS
- Brotli: ON

**Caching → Configuration:**
- Caching Level: Standard
- Browser Cache TTL: 4 hours

**Security:**
- Security Level: Medium
- Challenge Passage: 30 minutes
- Browser Integrity Check: ON

## Step 6: Connect Domain in Hostinger

1. hPanel → Hosting → Domains
2. Add `boomwarehouse.com` as primary domain (or change from preview URL)
3. Install SSL certificate (Let's Encrypt) via hPanel → SSL

## Step 7: Update WordPress URLs

```bash
wp option update siteurl "https://boomwarehouse.com"
wp option update home "https://boomwarehouse.com"
wp search-replace "darkseagreen-mallard-252962.hostingersite.com" "boomwarehouse.com" --all-tables
```

## Verification

```bash
# Check DNS propagation
dig boomwarehouse.com +short
# Should return Cloudflare IP (not Hostinger directly)

# Check SSL
curl -I https://boomwarehouse.com
# Should show HTTP/2 200, cf-ray header

# Check redirect
curl -I http://boomwarehouse.com
# Should show 301 → https://boomwarehouse.com
```

## Page Rules (Optional)

| URL Pattern | Setting |
|-------------|---------|
| `boomwarehouse.com/wp-admin/*` | Cache Level: Bypass |
| `boomwarehouse.com/wp-login.php` | Cache Level: Bypass |
| `*.boomwarehouse.com/*` | Cache Level: Cache Everything, Edge TTL: 2h |

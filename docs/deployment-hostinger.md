# Boom Warehouse — Deployment Guide (Hostinger)

## Architecture Overview

```
boomwarehouse.com
├── Cloudflare (DNS + CDN + SSL)
│   └── A record → Hostinger IP
├── Hostinger Business Hosting (WordPress + WooCommerce)
│   ├── wp-content/themes/boom-warehouse/  ← custom theme
│   ├── WooCommerce + plugins
│   └── MySQL database
├── Cloudflare R2 (product images)
└── Hostinger VPS KVM 2 (n8n automation)
    └── Docker: n8n + PostgreSQL
```

## Theme Deployment

### Option A: Git + SSH Deploy Script (Recommended)

```bash
# From local machine
./scripts/deploy-theme.sh
```

### Option B: Manual Upload

1. Zip the theme: `cd wp-content/themes && zip -r boom-warehouse.zip boom-warehouse/`
2. Upload via WP Admin > Appearance > Themes > Add New > Upload Theme
3. Activate the theme

### Option C: Hostinger Git Integration

1. hPanel > Advanced > Git
2. Create repository pointing to this GitHub repo
3. Set deploy branch: `main`
4. Deploy path: `public_html/wp-content/themes/boom-warehouse`
5. Enable auto-deploy on push

## Initial Setup Sequence

```bash
# 1. SSH into Hostinger
ssh u{account}@{hostname} -p 65002

# 2. Navigate to WordPress root
cd ~/public_html

# 3. Run master setup (requires WP-CLI)
bash /path/to/scripts/wp-master-setup.sh

# 4. Upload and activate theme
wp theme activate boom-warehouse

# 5. Import sample products (optional)
bash /path/to/scripts/wp-create-sample-products.sh

# Or use CSV import:
# WP Admin > WooCommerce > Products > Import > Upload product-import-template.csv
```

## n8n Deployment (VPS)

```bash
# SSH into Hostinger VPS
ssh root@{vps-ip}

# Clone repo
git clone https://github.com/tabletman/boom-warehouse.git
cd boom-warehouse/n8n

# Configure environment
cp .env.example .env
nano .env  # Fill in all values

# Start n8n
docker compose up -d

# Verify
docker compose logs -f n8n
# Should see: "n8n ready on port 5678"
```

### n8n Reverse Proxy (Nginx)

```nginx
server {
    server_name n8n.boomwarehouse.com;
    
    location / {
        proxy_pass http://localhost:5678;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

## Environment Variables Checklist

| Variable | Where | Status |
|----------|-------|--------|
| Stripe Test Keys | WP Admin > WooCommerce > Payments | [ ] Set |
| Stripe Live Keys | WP Admin > WooCommerce > Payments | [ ] Set |
| Acima Merchant ID | WP Admin > WooCommerce > Payments | [ ] Set |
| Acima API Key | WP Admin > WooCommerce > Payments | [ ] Set |
| Cloudflare R2 Keys | WP Admin > Offload Media | [ ] Set |
| GA4 Measurement ID | WP Admin > Site Kit | [ ] Set |
| SMTP Credentials | WP Admin > WP Mail SMTP | [ ] Set |
| n8n Password | n8n/.env | [ ] Set |
| WC API Keys (for n8n) | WP Admin > WooCommerce > Settings > Advanced > REST API | [ ] Set |

## Backup Strategy

| What | How | Frequency |
|------|-----|-----------|
| WordPress files + DB | Hostinger auto-backup | Daily |
| Theme source code | GitHub repo | Every commit |
| Product images | Cloudflare R2 (durable storage) | Real-time |
| n8n workflows | n8n export + Git | Weekly |
| Database export | `wp db export` via cron | Daily |

## Monitoring

- **Uptime:** Cloudflare analytics or UptimeRobot (free)
- **Performance:** Google PageSpeed Insights, Lighthouse
- **Security:** Wordfence dashboard, Cloudflare security analytics
- **Sales:** WooCommerce Analytics + GA4
- **Errors:** Wordfence activity log

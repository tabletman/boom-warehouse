#!/bin/bash
set -euo pipefail

# Boom Warehouse — Hostinger Cloud Setup
# Run as root on fresh Hostinger Cloud/VPS

echo "=== [1/7] System Update ==="
apt-get update -qq && apt-get upgrade -y -qq
apt-get install -y -qq curl git ufw fail2ban htop unzip jq

echo "=== [2/7] Docker ==="
command -v docker &>/dev/null || { curl -fsSL https://get.docker.com | sh; systemctl enable docker; }

echo "=== [3/7] Firewall ==="
ufw default deny incoming && ufw default allow outgoing
ufw allow 22/tcp && ufw allow 80/tcp && ufw allow 443/tcp
ufw --force enable

echo "=== [4/7] fail2ban ==="
cat > /etc/fail2ban/jail.local << 'EOF'
[sshd]
enabled = true
maxretry = 5
bantime = 3600
EOF
systemctl enable fail2ban && systemctl restart fail2ban

echo "=== [5/7] App User ==="
id boom &>/dev/null || useradd -m -s /bin/bash -G docker boom
mkdir -p /home/boom/app && chown -R boom:boom /home/boom

echo "=== [6/7] Clone ==="
[ -d /home/boom/app/.git ] \
  && su - boom -c 'cd ~/app && git pull origin main' \
  || su - boom -c 'git clone https://github.com/boom-warehouse/platform.git ~/app'

echo "=== [7/7] Env Template ==="
[ -f /home/boom/app/.env ] || {
cat > /home/boom/app/.env << 'ENV'
NODE_ENV=production
DB_USER=boom_admin
DB_PASSWORD=CHANGE_ME
DATABASE_URL=postgresql://boom_admin:CHANGE_ME@db:5432/boom_warehouse
REDIS_URL=redis://redis:6379
MEILI_URL=http://search:7700
MEILI_KEY=CHANGE_ME
NEXTAUTH_SECRET=CHANGE_ME
NEXTAUTH_URL=https://boomwarehouse.com
STRIPE_SECRET_KEY=sk_live_CHANGE_ME
STRIPE_PUBLISHABLE_KEY=pk_live_CHANGE_ME
STRIPE_WEBHOOK_SECRET=whsec_CHANGE_ME
ACIMA_API_KEY=CHANGE_ME
CLOUDFLARE_R2_ACCESS_KEY=CHANGE_ME
CLOUDFLARE_R2_SECRET_KEY=CHANGE_ME
CLOUDFLARE_R2_BUCKET=boom-assets
N8N_USER=admin
N8N_PASSWORD=CHANGE_ME
ENV
chown boom:boom /home/boom/app/.env && chmod 600 /home/boom/app/.env
echo "Edit /home/boom/app/.env with real creds, then: su - boom && cd ~/app && docker compose up -d --build"
}

echo "Setup complete"

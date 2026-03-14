#!/bin/bash
set -euo pipefail

# Boom Warehouse — Deploy Theme to Hostinger
# Usage: ./scripts/deploy-theme.sh [staging|production]

ENV="${1:-production}"
THEME_DIR="wp-content/themes/boom-warehouse"
REMOTE_PATH="public_html/wp-content/themes/boom-warehouse"

# Hostinger SSH config — update these
if [ "$ENV" = "staging" ]; then
  SSH_HOST="${BW_STAGING_SSH_HOST:-CHANGE_ME}"
  SSH_USER="${BW_STAGING_SSH_USER:-CHANGE_ME}"
  SSH_PORT="${BW_STAGING_SSH_PORT:-65002}"
else
  SSH_HOST="${BW_PROD_SSH_HOST:-CHANGE_ME}"
  SSH_USER="${BW_PROD_SSH_USER:-CHANGE_ME}"
  SSH_PORT="${BW_PROD_SSH_PORT:-65002}"
fi

echo "=== Deploying Boom Warehouse Theme ==="
echo "Environment: $ENV"
echo "Target: $SSH_USER@$SSH_HOST:$REMOTE_PATH"
echo ""

# Verify theme directory exists
if [ ! -d "$THEME_DIR" ]; then
  echo "ERROR: Theme directory not found: $THEME_DIR"
  exit 1
fi

# Verify style.css exists (valid WP theme)
if [ ! -f "$THEME_DIR/style.css" ]; then
  echo "ERROR: style.css not found — not a valid WordPress theme"
  exit 1
fi

# Sync theme files via rsync
echo "Syncing theme files..."
rsync -avz --delete \
  --exclude='.DS_Store' \
  --exclude='node_modules' \
  --exclude='.git' \
  -e "ssh -p $SSH_PORT" \
  "$THEME_DIR/" \
  "$SSH_USER@$SSH_HOST:$REMOTE_PATH/"

echo ""
echo "Activating theme..."
ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" \
  "cd ~/public_html && wp theme activate boom-warehouse" 2>/dev/null || {
  echo "  (WP-CLI not available via SSH — activate theme manually in WP Admin)"
}

echo ""
echo "Flushing caches..."
ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" \
  "cd ~/public_html && wp cache flush && wp rewrite flush" 2>/dev/null || {
  echo "  (Clear cache manually: WP Admin > LiteSpeed Cache > Purge All)"
}

echo ""
echo "=== Deploy complete ==="
echo "Verify: https://boomwarehouse.com"

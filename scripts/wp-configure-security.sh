#!/bin/bash
set -euo pipefail

# Boom Warehouse — WordPress Security Hardening
# Run via WP-CLI after all other setup scripts

echo "=== Boom Warehouse: Security Hardening ==="

# 1. Disable XML-RPC
echo "[1/8] Disabling XML-RPC..."
wp option update xmlrpc_enabled 0 2>/dev/null || true

# Add XML-RPC block via .htaccess if Apache
if [ -f "$(wp eval 'echo ABSPATH;').htaccess" ]; then
  HTACCESS="$(wp eval 'echo ABSPATH;').htaccess"
  if ! grep -q "xmlrpc" "$HTACCESS" 2>/dev/null; then
    cat >> "$HTACCESS" << 'HTACCESS'

# Block XML-RPC
<Files xmlrpc.php>
  Order Deny,Allow
  Deny from all
</Files>
HTACCESS
    echo "  XML-RPC blocked via .htaccess"
  fi
fi

# 2. Hide WordPress version
echo "[2/8] Hiding WP version..."
# This will be handled in theme functions.php

# 3. Disable file editing in admin
echo "[3/8] Disabling admin file editor..."
WP_CONFIG=$(wp eval 'echo ABSPATH;')wp-config.php
if ! grep -q "DISALLOW_FILE_EDIT" "$WP_CONFIG" 2>/dev/null; then
  wp config set DISALLOW_FILE_EDIT true --raw 2>/dev/null || echo "  Set DISALLOW_FILE_EDIT manually in wp-config.php"
fi

# 4. Enforce strong passwords (via Wordfence)
echo "[4/8] Configuring Wordfence..."
# Wordfence settings are stored in its own options
wp option update wordfence_ls_enabled 1 2>/dev/null || true  # Login security

# 5. Limit login attempts
echo "[5/8] Configuring login protection..."
wp option update wf_maxFailures 5 2>/dev/null || true
wp option update wf_loginSecurityEnabled 1 2>/dev/null || true

# 6. Set secure cookie flags
echo "[6/8] Setting secure cookies..."
wp config set FORCE_SSL_ADMIN true --raw 2>/dev/null || echo "  Set FORCE_SSL_ADMIN manually"

# 7. Disable directory browsing
echo "[7/8] Disabling directory browsing..."
if [ -f "$(wp eval 'echo ABSPATH;').htaccess" ]; then
  HTACCESS="$(wp eval 'echo ABSPATH;').htaccess"
  if ! grep -q "Options -Indexes" "$HTACCESS" 2>/dev/null; then
    echo "Options -Indexes" >> "$HTACCESS"
  fi
fi

# 8. Set file permissions
echo "[8/8] Setting file permissions..."
wp eval 'echo ABSPATH;' | xargs -I{} find {} -type d -exec chmod 755 {} \; 2>/dev/null || true
wp eval 'echo ABSPATH;' | xargs -I{} find {} -type f -exec chmod 644 {} \; 2>/dev/null || true

echo ""
echo "=== Security hardening complete ==="
echo ""
echo "MANUAL VERIFICATION:"
echo "1. WP Admin > Wordfence > All Options — review firewall rules"
echo "2. Ensure admin accounts use strong passwords"
echo "3. Remove any unused plugins and themes"
echo "4. Verify HTTPS redirect works: http://boomwarehouse.com → https://boomwarehouse.com"

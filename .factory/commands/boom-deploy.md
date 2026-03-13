---
description: "Deploy Boom Warehouse to production. Lint, test, build, deploy, health check."
argument-hint: "[--skip-tests] [--force]"
disable-model-invocation: true
---

Deploy to production. Run in order:

1. Lint + typecheck: `npm run lint && npm run typecheck`
2. Test suite (skip with --skip-tests): `npm run test:unit && npm run test:integration`
3. Build: `docker compose build --no-cache`
4. Push: `git add -A && git commit -m "chore: deploy $(date +%Y-%m-%d)" && git push origin main`
5. Monitor: GitHub Actions handles the deploy
6. Health check:
   ```bash
   curl -sf https://boomwarehouse.com/api/health || echo "HEALTH CHECK FAILED"
   curl -sf https://boomwarehouse.com/ || echo "STOREFRONT CHECK FAILED"
   ```

Start with step 1 now.

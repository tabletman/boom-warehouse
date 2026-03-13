---
description: "Swarm-enabled LFG for Boom Warehouse. Parallelizes across storefront, API, admin, and infra droids with compound-engineering reviewers."
argument-hint: "[feature or milestone description]"
disable-model-invocation: true
---

Swarm-enabled LFG for Boom Warehouse. Run these steps in order, parallelizing where indicated. Do not stop between steps — complete every step through to the end.

## Sequential Phase

1. `/plan $ARGUMENTS`
2. `/deepen-plan`

## Parallel Build Phase (Swarm Mode)

3. **Launch swarm**: Create a Task list and spawn parallel agents:

**Group A — Application (simultaneous):**
- Task: `boom-storefront` droid — Build/update storefront components per plan
- Task: `boom-inventory-api` droid — Build/update API endpoints per plan
- Task: `boom-admin` droid — Build/update admin dashboard per plan

**Group B — Infrastructure (simultaneous):**
- Task: `boom-infra` droid — Docker/CI-CD/deploy config per plan
- Task: `general-purpose` subagent — Database schema + migrations + seed data per plan (reference boom-inventory skill)

Wait for all Group A + B tasks to complete before continuing.

## Parallel Review Phase

4. Launch these as **parallel swarm agents** (both only need code to be written):
   - `compound-engineering:review:security-sentinel` — Security audit all new code
   - `compound-engineering:review:kieran-typescript-reviewer` — TS best practices
   - `compound-engineering:review:performance-oracle` — Perf analysis
   - `compound-engineering:review:code-simplicity-reviewer` — YAGNI check
   - `compound-engineering:review:data-integrity-guardian` — DB + data safety

Wait for all reviews to complete before continuing.

## Finalize Phase

5. `/resolve_todo_parallel` — Resolve findings from all reviewers
6. `/test-browser` — Run Playwright E2E tests on critical paths
7. `/review` — Final synthesis review
8. Output `<promise>DONE</promise>` when all reviews pass and tests green

Start with step 1 now.

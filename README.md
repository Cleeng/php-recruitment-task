# Cleeng PHP Developer Task

Welcome! This small subscription API is a slice of the kind of system we
build at Cleeng. Customers purchase offers; purchases create subscriptions.

## Setup

Requirements: Docker with the compose plugin.

    make up      # build, start, migrate, load fixtures  → http://localhost:8080
    make test    # run the test suite

Try it: `curl http://localhost:8080/offers`

If `make up` fails, check that ports 8080 and 33306 are free. Both images
are multi-arch (x86/ARM). `make down` resets everything, volumes included.

## Before you start

`openspec/specs/` is the source of truth for how every endpoint must
behave. When in doubt, the spec wins.

`AGENTS.md` documents the conventions and working practices of this
repository. They apply to the work you submit, not just to the tools you
point at it.

**AI tools are expected.** We work AI-first and you should approach this
task the way you'd work with us day to day: Claude Code, Cursor, Copilot —
whatever you actually use. The repository is set up for AI-assisted
development the same way our production repositories are; what that means is
yours to discover and use. In the follow-up interview you'll walk us
through *how* you worked — your prompts, what you leveraged, and where you
pushed back on what the tools gave you. We care that you understand and can
defend everything you ship.

## Your tasks

### 1. A bug report from support

> Customer `alice@example.com` subscribed to a monthly offer on
> **2026-08-31**. Her subscription shows it expires on **2026-10-01**.
> Per our product rules it should expire on **2026-09-30**.

Investigate and fix.

### 2. Cancel a subscription

`POST /subscriptions/{id}/cancel` is specified in
`openspec/specs/subscriptions/spec.md` (Requirement: Subscription
cancellation) but is not implemented. Implement it per the spec, with tests.

### 3. (Optional bonus) API documentation

API Platform is a dependency of this app but is not wired up. Expose
OpenAPI documentation for the existing endpoints — all of them, error
responses included, with `make test` still green. Note in `NOTES.md` where
your docs live and how you did it.

## Time & expectations

- **Time cap: 2 hours.** Stop when time is up — then add a short `NOTES.md`:
  what you did, decisions you made, and what you'd do with more time.
  An honest, unfinished submission beats an over-polished one.
- **Commit as you go, test first.** We look for the failing test before the
  implementation it justifies — granular commits help us follow your story,
  and the repo's own history shows the style we like.
- Task 3 is genuinely optional. Skipping it does not count against you.

## What we evaluate

- Correctness against `openspec/specs/`
- HTTP and error semantics (status codes, error codes, response shapes)
- Fit with the existing code's conventions and patterns
- Tests for what you change and add
- A commit history we can follow
- Your `NOTES.md`

## What we do NOT evaluate

Authentication, CI pipelines, deployment, performance tuning, or anything
not described in the specs. Don't build it.

## Submitting

Clone this repository and push it to a **private** repository on your own
GitHub account — that's where you work and commit. When you're done, make
sure everything is pushed and give `michalmlynarczykcleeng` read access so
we can review your work before the follow-up conversation.

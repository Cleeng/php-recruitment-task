# php-recruitment-task

Minimal subscription API. Symfony 7.3, PHP 8.4, Doctrine, MySQL (docker).

## Commands

- `make up` — build, start, migrate, load fixtures
- `make test` — prepare test database and run the PHPUnit suite
- `make sh` — shell inside the app container

## Source of Truth

`openspec/specs/` defines the required behavior of every endpoint. When code,
tests, and spec disagree, the spec wins.

## Principles

1. **Search before writing** — look for an existing pattern in this codebase
   and follow it; consistency beats novelty.
2. **Test-first for new features** — the failing test comes before the
   implementation, and the commit history should show it.
3. **Bug fixes ship with a regression test** — first reproduce the reported
   behavior in a failing test, then fix, then show the suite green.
4. **No premature abstraction** — no layers, interfaces, or options that
   today's requirement doesn't need.
5. **Intention-revealing domain methods** — `$invoice->markPaid($now)`,
   never `setStatus()`. Time flows through the injected `ClockInterface`,
   dates are `DateTimeImmutable`, money is integer minor units.

## Skills

Reusable playbooks for common jobs in this repo live in `.claude/skills/`.

# Project Context

## Purpose
Minimal slice of a subscription platform: customers purchase offers, producing
subscriptions. Used as a working example of how we build API endpoints.

## Tech Stack
PHP 8.4, Symfony 7.3, Doctrine ORM, MySQL 8, PHPUnit. Runs via `make up`;
tests via `make test`.

## Conventions
- Money: integer minor units (999 = 9.99). Currency: ISO 4217 code.
- Dates: `DateTimeImmutable`, UTC, serialized as ATOM (`2026-01-15T12:00:00+00:00`).
- Current time always comes from the injected `Symfony\Component\Clock\ClockInterface`.
- Controllers stay thin: resolve input, delegate to a service, shape the response.
- Error responses: `{"error": {"code": "<snake_case_code>", "message": "<text>"}}`.
  Validation errors (422) additionally carry `violations: [{"field", "message"}]`.
- These specs are the source of truth. Behavior not covered here is undefined;
  behavior described here is required.

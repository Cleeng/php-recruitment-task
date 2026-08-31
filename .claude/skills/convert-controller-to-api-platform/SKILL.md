---
name: convert-controller-to-api-platform
description: Use when exposing this app's Symfony controller endpoints through API Platform — wiring the OpenAPI documentation surface or converting a controller to an API Platform resource. Triggers on "expose docs", "OpenAPI", "swagger", "wire API Platform", "convert controller".
---

# Convert Controller to API Platform

API Platform is installed (`composer.json`) and its bundle is registered,
but nothing is wired: no routes, no resources.

## Phase 0: Wire the bundle

1. Create `config/routes/api_platform.yaml`:

       api_platform:
           resource: .
           type: api_platform
           prefix: /api

2. In `config/packages/api_platform.yaml`, point resource discovery at a
   dedicated directory (create it):

       api_platform:
           title: 'Subscription API'
           version: '1.0.0'
           mapping:
               paths: ['%kernel.project_dir%/src/ApiResource']

3. Verify by requesting the OpenAPI document itself, not an HTML UI: this
   stack does not have `symfony/twig-bundle` installed, so Swagger UI,
   ReDoc, and Scalar stay disabled and `GET /api/docs` returns a JSON-LD
   document (not a rendered page). Request the OpenAPI JSON directly, e.g.
   `GET /api/docs.jsonopenapi` (API Platform 4's format-suffixed routing)
   — an empty `paths: {}` is fine at this point. If that 404s, check the
   route import and clear the cache.

## Phase 1: Inventory what you document

For each route, collect from `openspec/specs/`, the controller, and the
functional tests: path, HTTP method, request body shape, success status +
response shape, error status/codes. The spec is the contract — the
documentation must not invent or omit fields.

## Phase 2: Verify

- Every existing endpoint appears in the document, with the schemas and
  error responses the spec requires.
- `make test` is green — the existing suite keeps passing unchanged.
- Nothing in `openspec/specs/` is contradicted by the live behavior.

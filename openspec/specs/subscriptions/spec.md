# subscriptions Specification

## Purpose
Purchasing offers (checkout), inspecting a customer's subscriptions, and
cancelling subscriptions.

## Requirements

### Requirement: Checkout
The system SHALL expose `POST /subscriptions` accepting
`{"customerId": int, "offerId": int}` and creating an ACTIVE subscription.

#### Scenario: Successful checkout
- **WHEN** a valid customer purchases an active offer they are not actively
  subscribed to
- **THEN** the response is `201` with the subscription representation,
  `status` is `ACTIVE`, `startedAt` is the current time, `cancelledAt` is
  null, and `expiresAt` follows the Expiry date computation requirement

#### Scenario: Unknown customer
- **WHEN** `customerId` does not match an existing customer
- **THEN** the response is `404` with error code `customer_not_found`

#### Scenario: Unknown or inactive offer
- **WHEN** `offerId` does not match an existing offer, or matches an
  inactive offer
- **THEN** the response is `404` with error code `offer_not_found`

#### Scenario: Duplicate active subscription
- **WHEN** the customer already has an ACTIVE subscription for the offer
- **THEN** the response is `409` with error code `already_subscribed`

#### Scenario: Invalid request body
- **WHEN** the body is missing `customerId` or `offerId`, or they are not
  positive integers
- **THEN** the response is `422` with error code `validation_failed` and a
  `violations` list naming each invalid field

### Requirement: Expiry date computation
A subscription's `expiresAt` SHALL be `startedAt` plus the offer's billing
period, anchored to the start day-of-month (the anniversary day). When the
target month is shorter than the anniversary day, `expiresAt` SHALL fall on
the **last day of the target month** — it must never roll over into the
following month.

#### Scenario: Monthly mid-month
- **WHEN** a P1M offer is purchased on 2026-01-15
- **THEN** `expiresAt` is 2026-02-15

#### Scenario: Monthly at month end
- **WHEN** a P1M offer is purchased on 2026-01-31
- **THEN** `expiresAt` is 2026-02-28

#### Scenario: Yearly mid-month
- **WHEN** a P1Y offer is purchased on 2026-03-15
- **THEN** `expiresAt` is 2027-03-15

#### Scenario: Yearly on leap day
- **WHEN** a P1Y offer is purchased on 2028-02-29
- **THEN** `expiresAt` is 2029-02-28

### Requirement: Customer subscriptions listing
The system SHALL expose `GET /customers/{id}/subscriptions` returning all of
the customer's subscriptions (any status) as a JSON array.

#### Scenario: Existing customer
- **WHEN** the customer exists
- **THEN** the response is `200` with an array of subscription representations

#### Scenario: Unknown customer
- **WHEN** the customer does not exist
- **THEN** the response is `404` with error code `customer_not_found`

### Requirement: Subscription cancellation
The system SHALL expose `POST /subscriptions/{id}/cancel`. Cancellation ends
renewal but SHALL NOT end access: the subscription keeps its `expiresAt`.

#### Scenario: Cancel an active subscription
- **WHEN** the subscription status is ACTIVE
- **THEN** the response is `200` with the subscription representation,
  `status` is `CANCELLED`, `cancelledAt` is the current time, and
  `expiresAt` is unchanged

#### Scenario: Cancel an already cancelled subscription
- **WHEN** the subscription status is CANCELLED
- **THEN** the response is `200` with the unchanged representation —
  cancellation is idempotent and `cancelledAt` SHALL NOT be updated

#### Scenario: Cancel an expired subscription
- **WHEN** the subscription status is EXPIRED
- **THEN** the response is `409` with error code `cannot_cancel_expired`

#### Scenario: Unknown subscription
- **WHEN** the subscription id does not exist
- **THEN** the response is `404` with error code `subscription_not_found`

### Requirement: Subscription representation
Subscription JSON SHALL contain: `id`, `customerId`, `offerId`, `status`
(`ACTIVE`|`CANCELLED`|`EXPIRED`), `startedAt`, `expiresAt` (ATOM strings),
`cancelledAt` (ATOM string or null). Subscriptions become EXPIRED through an
out-of-band process not part of this codebase.

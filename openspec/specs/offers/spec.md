# offers Specification

## Purpose
Expose the catalog of purchasable offers.

## Requirements

### Requirement: Offer listing
The system SHALL expose `GET /offers` returning all active offers as a JSON
array. Inactive offers SHALL NOT appear.

#### Scenario: List active offers
- **WHEN** `GET /offers` is requested
- **THEN** the response is `200` with a JSON array of offers, each with
  `id`, `title`, `price` (int, minor units), `currency`, `billingPeriod`
  (`P1M` or `P1Y`), and inactive offers are absent

### Requirement: Offer detail
The system SHALL expose `GET /offers/{id}` returning a single offer.

#### Scenario: Existing offer
- **WHEN** `GET /offers/{id}` is requested for an existing offer
- **THEN** the response is `200` with the offer object

#### Scenario: Unknown offer
- **WHEN** `GET /offers/{id}` is requested for a non-existent id
- **THEN** the response is `404` with error code `offer_not_found`

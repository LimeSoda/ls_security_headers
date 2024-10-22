# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Add support for nonce attribute output in `generateNonce` method

### Changed
- Migrate to `security/ignorePageTypeRestriction` flag in TCA
- Migrate and improve TCA configuration
- Rename `Userfuncs` namespace to `UserFunctions`

### Removed
- Remove obsolete TCEforms tag from FlexForms
- Remove obsolete `ext_tables.sql` file

## [1.3.2] - 27-08-2024

### Fixed
- Don't set header if value is empty

## [1.3.1] - 31-07-2024

### Changed
- Ensures compatibility with PHP 8.3.

## [1.3.0] - 25-04-2023

### Changed
- Convert nonce generation from ViewHelper to TypoScript object to avoid caching problems

## [1.2.0] - 20-04-2023

### Added
- Add support for nonces (for further information check the [README](README.md))

## [1.1.0] - 29-03-2023

### Changed
- Adjust requirements to include both Typo3 11 and 12

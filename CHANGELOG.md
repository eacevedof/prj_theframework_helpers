# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Enum classes for type-safe HTML values:
  - `HtmlTypeEnum` - HTML tag names
  - `HtmlAttrEnum` - HTML attributes
  - `InputTypeEnum` - Input type values
  - `ButtonTypeEnum` - Button type values
  - `MediaTypeEnum` - Media type values
  - `LinkRelEnum` - Link rel attribute values
  - `ColorEnum` - Common color names
  - `CompareOperatorEnum` - Comparison operators
  - `RangeKeyEnum` - Range key names (min/max)
- Google Maps specific enums under `Enums\GoogleMaps\` namespace
- PHPUnit test suite configuration
- Unit tests for Button, Select, and Enum classes

### Changed
- Updated PHP requirement to 8.1+
- Refactored HTML helper classes to use enum constants
- Improved code structure with early return patterns
- Extracted magic strings to enum classes
- Updated README with better documentation

### Fixed
- Method naming conventions for boolean getters (is*, has*)
- Nested if/else structures simplified with early returns

## [0.1.0] - 2018-12-15

### Added
- Initial release
- Form helpers (Input, Select, Textarea, Radio)
- HTML helpers (Button, Link, Script, Table)
- PSR-4 autoloading support

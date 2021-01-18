# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [1.1.3] - 2020-01-18

### Fixed
- Fixed composer.json version, re-tagging to redeploy to packagist.

## [1.1.2] - 2020-01-18

### Added
- Added test rewrite to MFTF to get core tests to pass when 2FA is disabled ([#5](https://github.com/markshust/magento2-module-disabletwofactorauth/pull/5)).

## [1.1.1] - 2020-01-13

### Fixed
- Removed typed properties for PHP 7.3 support ([#6](https://github.com/markshust/magento2-module-disabletwofactorauth/issues/6)).

## [1.1.0] - 2020-01-12

### Added
- Support to disable 2FA for API token generation ([#1](https://github.com/markshust/magento2-module-disabletwofactorauth/issues/1)).

### Updated
- Updated docblocks and other minor formatting issues.
- Updated REAMDE to make it more explicit not to disable 2FA within production environments.

## [1.0.0] - 2020-08-10

### Added
- Initial release.

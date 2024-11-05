# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [2.0.2] - 2024-11-05

### Added
- Added PHPStan level 9 support by improving type hints ([#27](https://github.com/markshust/magento2-module-disabletwofactorauth/pull/27))
- Added keywords to composer.json for better package discovery

### Updated
- Updated installation instructions to recommend using `--dev` flag with composer
- Made package explicitly development-focused to avoid Adobe Commerce security warnings ([#28](https://github.com/markshust/magento2-module-disabletwofactorauth/pull/28))
- Updated badge icon with support for newer versions of Magento

### Fixed
- Fixed issue where 2FA could remain enabled for API token generation when main 2FA was disabled ([#29](https://github.com/markshust/magento2-module-disabletwofactorauth/pull/29))

## [2.0.1] - 2022-10-24

### Fixed
- Fix compatibility with MFTF 3.10.0 ([#16](https://github.com/markshust/magento2-module-disabletwofactorauth/pull/16))

## [2.0.0] - 2021-11-10

This is a potentially breaking release, as it changes the overall functionality when Magento is in `developer` mode. A new "Disable 2FA in Developer Mode" system configuration has been created, which is a Yes/No toggle. By default, it is set to Yes so that 2FA is automatically disabled when a Magento site is in `developer` mode. When this is set to No, the two other 2FA configuration dropdowns set the configuration for 2FA. When not in `developer` mode, this toggle has no effect.

### Added
- Add ability to automatically disable 2FA when in developer mode ([#13](https://github.com/markshust/magento2-module-disabletwofactorauth/pull/13)).

## [1.1.4] - 2021-02-22

### Fixed
- Removed newline character from MFTF config:show bool cast ([#10](https://github.com/markshust/magento2-module-disabletwofactorauth/pull/10)).

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

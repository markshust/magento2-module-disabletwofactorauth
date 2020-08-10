<h1 align="center">MarkShust_DisableTwoFactorAuth</h1> 

<div align="center">
  <p>Provides the ability to disable two-factor authentication.</p>
  <img src="https://img.shields.io/badge/magento-2.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square" alt="Supported Magento Versions" />
  <a href="https://packagist.org/packages/markshust/magento2-module-disabletwofactorauth" target="_blank"><img src="https://img.shields.io/packagist/v/markshust/magento2-module-disabletwofactorauth.svg?style=flat-square" alt="Latest Stable Version" /></a>
  <a href="https://packagist.org/packages/markshust/magento2-module-disabletwofactorauth" target="_blank"><img src="https://poser.pugx.org/markshust/magento2-module-disabletwofactorauth/downloads" alt="Composer Downloads" /></a>
  <a href="https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity" target="_blank"><img src="https://img.shields.io/badge/maintained%3F-yes-brightgreen.svg?style=flat-square" alt="Maintained - Yes" /></a>
  <a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/badge/license-MIT-blue.svg" /></a>
</div>

## Table of contents

- [Summary](#summary)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

## Summary

With the release of Magento 2.4, two-factor authentication (also known as 2FA) became enabled by default, with no
ability to disable it in either the admin or console. However, there are situations which may require 2FA to be disabled
or temporarily turned off, such as within development or testing environments.

This module adds the missing toggle to turn 2FA on or off from the admin. It does this by hooking into the core code in
a very seamless manner, just as would be done if this toggle existed in the core code. Installing this module should not
open up any security holes, as it just works off of a simple config toggle which if not present, falls back to default
functionality. 
 
![Demo](https://raw.githubusercontent.com/markshust/magento2-module-disabletwofactorauth/master/docs/demo.png)

## Installation

```
composer require markshust/magento2-module-disabletwofactorauth
bin/magento module:enable MarkShust_DisableTwoFactorAuth
bin/magento setup:upgrade
```

## Usage

This module keeps 2FA enabled by default. This is to prevent any unexpected side effects or security loopholes from
being introduced during automated installation processes.

After installing the module, one can disable 2FA by going to **Admin > Stores > Settings > Configuration >
Security > 2FA**, and setting *Enable 2FA* to **No**.

This setting can also be toggled to a 1 or 0 to respectively enable or disable 2FA from the command-line console:

```
bin/magento config:set twofactorauth/general/enable 0
```

## License

[MIT](https://opensource.org/licenses/MIT)

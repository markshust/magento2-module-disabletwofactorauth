<h1 align="center">MarkShust_DisableTwoFactorAuth</h1> 

<div align="center">
  <p>Provides the ability to disable two-factor authentication.</p>
  <img src="https://img.shields.io/badge/magento-2.4.0%E2%80%932.4.7+-brightgreen.svg?logo=magento&longCache=true&style=flat-square" alt="Supported Magento Versions" />
  <a href="https://packagist.org/packages/markshust/magento2-module-disabletwofactorauth" target="_blank"><img src="https://img.shields.io/packagist/v/markshust/magento2-module-disabletwofactorauth.svg?style=flat-square" alt="Latest Stable Version" /></a>
  <a href="https://packagist.org/packages/markshust/magento2-module-disabletwofactorauth" target="_blank"><img src="https://poser.pugx.org/markshust/magento2-module-disabletwofactorauth/downloads" alt="Composer Downloads" /></a>
  <a href="https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity" target="_blank"><img src="https://img.shields.io/badge/maintained%3F-yes-brightgreen.svg?style=flat-square" alt="Maintained - Yes" /></a>
  <a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/badge/license-MIT-blue.svg" /></a>
</div>

## Table of contents

- [Summary](#summary)
- [Why](#why)
- [Installation](#installation)
- [Usage](#usage)
- [Credits](#credits)
- [License](#license)

## Summary

With the release of Magento 2.4, two-factor authentication (also known as 2FA) became enabled by default, with no
ability to disable it in either the admin or console. However, there are situations which may require 2FA to be disabled
or temporarily turned off, such as within development or testing environments.

This module automatically disables 2FA while in developer mode (since version 2.0.0), and adds the missing toggle to turn 2FA on or off from the admin for other environments. It does this by hooking into the core code in
a very seamless manner, just as would be done if this toggle existed in the core code. Installing this module should not
open any security holes, as it just works off of a simple config toggle which, if not present, falls back to the default
functionality.

You can also toggle 2FA back on while in developer mode, if you need to test your code functionality while 2FA is enabled.
 
![Demo](https://raw.githubusercontent.com/markshust/magento2-module-disabletwofactorauth/master/docs/demo-2021-11-10.png)

## Why

Why should you use this module? I hear all of the time that you can just disable Magento's 2FA module. There is a large inherent issue with doing this though.

When you disable a module, it updates the `app/etc/config.php` file with the removed module, which will eventually make its way upstream (accidentally committed to version control or unintendedly leaving your development environment). This will disable 2FA on staging/production, which is a big security concern. This module resolves this because you can keep it installed & enabled on dev/stage/prod, but control whether or not 2FA is enabled or disabled with configuration settings or environment variables. This means you can have it permanently disabled on dev, but have it permanently enabled in all other environments, all while keeping this module installed in all environments.

## Installation

```
composer require --dev markshust/magento2-module-disabletwofactorauth
bin/magento module:enable MarkShust_DisableTwoFactorAuth
bin/magento setup:upgrade
```

## Usage

This module automatically disables 2FA in developer mode (since version 2.0.0). In any other deployment mode, 2FA is kept enabled by default. This is to prevent any unexpected side effects or security loopholes from
being introduced during automated installation processes.

It is highly recommended to install this module as a dev dependency to avoid security warning reports from either Adobe Commerce or other production environments which run security checks. This can be done either by passing in the `--dev` flag when installing it with Composer, or by adding it to the `require-dev` property of your `composer.json` file.

### Disable 2FA

It may still be desirable to disable 2FA in non-production environments, such as within testing or internal staging environments. For these cases, 2FA is not automatically disabled. However, there are toggles to override the default Magento settings to disable 2FA within these environments.

You can also bypass 2FA for API token generation. This can be useful for third-party vendors during module development.

*NOTE: Always keep 2FA enabled within production environments for security purposes.*

#### 2FA

To disable 2FA, visit **Admin > Stores > Settings > Configuration > Security > 2FA** and set *Enable 2FA* to **No**.

CLI: `bin/magento config:set twofactorauth/general/enable 0`

#### 2FA for API Token Generation

To disable 2FA for API Token Generation, visit **Admin > Stores > Settings > Configuration > Security > 2FA** and set *Enable 2FA for API Token Generation* to **No**.

CLI: `bin/magento config:set twofactorauth/general/enable_for_api_token_generation 0`

### Enable 2FA in developer mode

This module automatically disables 2FA while developer mode is enabled, but there may be situations when you need 2FA enabled during development. Rather than needing to disable this module, you can just disable this configuration setting in the admin.

To enable 2FA while in developer mode, visit **Admin > Stores > Settings > Configuration > Security > 2FA** and set *Disable 2FA in Developer Mode* to **No**.

CLI: `bin/magento config:set twofactorauth/general/disable_in_developer_mode 0`

## Credits

### M.academy

This course is sponsored by <a href="https://m.academy/" target="_blank">M.academy</a>, the simplest way to master Magento development.

<a href="https://m.academy/" target="_blank"><img src="docs/macademy-logo-200x60.png" alt="M.academy"></a>

### Mark Shust

My name is Mark Shust and I am a 6X Adobe Commerce Certified Developer and the founder of <a href="https://m.academy" target="_blank">M.academy</a>. Since the early days of Magento, I've been involved with many intricately complex eCommerce and open-source projects.

My passion is teaching and helping others learn Magento, and has created many courses and tutorials to help thousands of students from all over the world to learn and improve their Magento skills.

- <a href="https://m.academy/courses/" target="_blank">🖥️ Learn with Magento courses</a>
- <a href="https://m.academy/articles/" target="_blank">📖 Read my technical articles</a>
- <a href="https://www.linkedin.com/in/MarkShust/" target="_blank">🔗 Connect on LinkedIn</a>
- <a href="https://youtube.com/markshust" target="_blank">🎥 Watch on YouTube</a>
- <a href="https://twitter.com/MarkShust" target="_blank">🐦 Follow me on X</a>
- <a href="https://m.academy/contact/" target="_blank">💌 Contact me</a>

## License

[MIT](https://opensource.org/licenses/MIT)

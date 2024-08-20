

  

<h1 align="center">RSilva_DisableTwoFactorAuth</h1>

<div align="center">

<p>Provides the ability to disable two-factor authentication on developer mode.</p>


| Magento Version | Latest Stable Version | Composer Downloads | Maintaned | Licence
|--|--|--|--|--|
| <img  src="https://img.shields.io/badge/magento-2.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square"  alt="Supported Magento Versions"  /> | <a  href="https://packagist.org/packages/markshust/magento2-module-disabletwofactorauth"  target="_blank"><img  src="https://img.shields.io/packagist/v/markshust/magento2-module-disabletwofactorauth.svg?style=flat-square"  alt="Latest Stable Version"  /></a> | <a  href="https://packagist.org/packages/markshust/magento2-module-disabletwofactorauth"  target="_blank"><img  src="https://poser.pugx.org/markshust/magento2-module-disabletwofactorauth/downloads"  alt="Composer Downloads"  /></a> | <a  href="https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity"  target="_blank"><img  src="https://img.shields.io/badge/maintained%3F-yes-brightgreen.svg?style=flat-square"  alt="Maintained - Yes"  /></a> | <a  href="https://opensource.org/licenses/MIT"  target="_blank"><img  src="https://img.shields.io/badge/license-MIT-blue.svg"  /></a>

  



  


  



  

</div>

  

  

## Table of contents

  

  

-  [Summary](#summary)

  

-  [Installation](#installation)

  

-  [Usage](#usage)

  

-  [License](#license)

  

  

## Summary

  

This modules uses Mark Shust https://github.com/markshust/magento2-module-disabletwofactorauth as base.

The major difference is that with this module you **CAN'T disable** 2FA in **production** mode.

  

## Installation  

```
composer require rsilva/disabletwofactorauth

bin/magento module:enable RSilva_DisableTwoFactorAuth 

bin/magento setup:upgrade 

```

## Usage

This module automatically disables 2FA in developer mode (since version 2.0.0).  This is to prevent any unexpected side effects or security loopholes from being introduced during automated installation processes.
   

### Enable 2FA in developer mode

This module automatically disables 2FA while developer mode is enabled, but there may be situations when you need 2FA enabled during development. Rather than needing to disable this module, you can just disable this configuration setting in the admin.

To enable 2FA while in developer mode, visit **Admin > Stores > Settings > Configuration > Security > 2FA** and set *Disable 2FA in Developer Mode* to **No**.

CLI: `bin/magento config:set twofactorauth/general/disable_in_developer_mode 0`


## License

[MIT](https://opensource.org/licenses/MIT)

# Product Quick View - Magento 2
---

This Magento 2 extension provides quick view button, popup view the product from product list, widget.

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/a0c2c8faab694998abc3c90ad3e7cc98)](https://www.codacy.com/manual/GhoSterInc/ProductQuickView?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=tuyennn/ProductQuickView&amp;utm_campaign=Badge_Grade)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/thinghost)
[![Build Status](https://travis-ci.org/tuyennn/ProductQuickView.svg?branch=master)](https://travis-ci.org/tuyennn/ProductQuickView)
![Version 1.0.0](https://img.shields.io/badge/Version-1.0.0-green.svg)

---
## [![Alt GhoSter](http://thinghost.info/wp-content/uploads/2015/12/ghoster.png "thinghost.info")](http://thinghost.info) Overview

- [Extension on GitHub](https://github.com/tuyennn/ProductQuickView)
- [Direct download link](https://github.com/tuyennn/ProductQuickView/tarball/master)


![Alt Screenshot-1](http://thinghost.info/wp-content/uploads/2015/12/Selection_120-1024x654.jpg "thinghost.info")
![Alt Screenshot-3](http://thinghost.info/wp-content/uploads/2015/12/Selection_122-1024x724.jpg "thinghost.info")
![Alt Screenshot-4](https://thinghost.info/wp-content/uploads/2015/12/Selection_123-1024x520.jpg "thinghost.info")

## Main Features

* Add a quick view button from product list.
* Add a quick view button from product widget.
* No overriding templates
* Support DOM-selector for button location.

## Configure and Manage

* Enable Module - Enable or disable module.
* Enable Quick View on Product Listing - Enable/Disable Quick View Category pages.
* Category Page Label Container - DOM-selector for Container.
* Enable view detail button product - Enable/Disable view detail Product button.

## Installation with Composer

* Connect to your server with SSH
* Navigation to your project and run these commands
 
```bash
composer require ghoster/product-quickview


php bin/magento setup:upgrade
rm -rf pub/static/* 
rm -rf var/*

php bin/magento setup:static-content:deploy
```

## Installation without Composer

* Download the files from github: [Direct download link](https://github.com/tuyennn/ProductQuickView/tarball/master)
* Extract archive and copy all directories to app/code/GhoSter/Quickview
* Go to project home directory and execute these commands

```bash
php bin/magento setup:upgrade
rm -rf pub/static/* 
rm -rf var/*

php bin/magento setup:static-content:deploy
```

## Contribution

* Fork this repository
* Create your feature branch (`git checkout -b your-new-feature`) always from `develop`
* Commit and Submit a new Pull Request

## Licence

[Open Software License (OSL 3.0)](http://opensource.org/licenses/osl-3.0.php)


## Donation

If this project help you reduce time to develop, you can give me a cup of coffee :) 

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.me/thinghost)

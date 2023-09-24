[![License](https://poser.pugx.org/tcgunel/omnipay-tokenflex/license)](https://packagist.org/packages/tcgunel/omnipay-tokenflex)
[![Buy us a tree](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen)](https://plant.treeware.earth/tcgunel/omnipay-tokenflex)
[![PHP Composer](https://github.com/tcgunel/omnipay-tokenflex/actions/workflows/tests.yml/badge.svg)](https://github.com/tcgunel/omnipay-tokenflex/actions/workflows/tests.yml)

# Omnipay Tokenflex Gateway
Omnipay gateway for Tokenflex. All the methods of Tokenflex implemented for easy usage.

## Requirements
| PHP       | Package |
|-----------|---------|
| ^7.4-^8.0 | v1.0.0  |

## Installment

```
composer require tcgunel/omnipay-tokenflex
```

## Usage

Please see the [Wiki](https://github.com/tcgunel/omnipay-tokenflex/wiki) page for detailed usage of every method.

## Methods

* purchase() // Ön provizyon açma servisi.
* completePurchase() // Ön provizyondaki işlemi provizyona çekme.
* refund() // Ön provizyon iptali.
* void() // Provizyon iptali.
* verifyOtp() // Otp doğrulama.
* resendOtp() // Otp kodunu tekrar gönderme.
* fetchTransaction() // Satış durumu öğrenme.

## Tests
```
composer test
```
For windows:
```
vendor\bin\paratest.bat
```

## Treeware

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**](https://plant.treeware.earth/tcgunel/omnipay-tokenflex) to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

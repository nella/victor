# Victor - for [Composer](https://getcomposer.org)

[![Build Status](https://img.shields.io/travis/nella/victor/master.svg?style=flat-square)](https://travis-ci.org/nella/victor)
[![Windows Build Status](https://img.shields.io/appveyor/ci/Vrtak-CZ/victor/master.svg?style=flat-square)](https://ci.appveyor.com/project/Vrtak-CZ/victor)
[![Code Coverage](https://img.shields.io/coveralls/nella/victor.svg?style=flat-square)](https://coveralls.io/r/nella/victor)
[![SensioLabsInsight Status](https://img.shields.io/sensiolabs/i/3e962886-fa83-4601-a7d9-e75395111542.svg?style=flat-square)](https://insight.sensiolabs.com/projects/3e962886-fa83-4601-a7d9-e75395111542)
[![Latest Stable Version](https://img.shields.io/packagist/v/nella/victor.svg?style=flat-square)](https://packagist.org/packages/nella/victor)
[![Github Downloads](https://img.shields.io/github/downloads/nella/victor/total.svg?style=flat-square)](https://github.com/nella/victor)
[![HHVM Status](https://img.shields.io/hhvm/nella/victor.svg?style=flat-square)](http://hhvm.h4cc.de/package/nella/victor)
![License MIT, GPL-2, GPL-3](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)

Victor is a version updates checker for your composer package requirements.

Why? I know there is [Versioneye](https://www.versioneye.com/) which is great.
But _Versioneye_ ignores your requirement preferences and doesn't support private repositories (satis).

## Instalation

```bash
wget https://github.com/nella/victor/releases/download/v1.1.0/victor.phar -O victor.phar
# or
curl -o victor.phar https://github.com/nella/victor/releases/download/v1.1.0/victor.phar
```

## Usage

Run this command in root of your project.

```
php victor.phar
```

![Latest preview](https://github.com/nella/victor/blob/master/build/latest.png)
![Update preview](https://github.com/nella/victor/blob/master/build/update.png)

Ignore required version opition (`--ignore-required-version|-f`).
If you require package `"nella/victor": "~1.0.0"` in your `composer.json`.
_Victor_ also shows you _minor_ and _major_ version updates.

```
php victor.phar show -f
```

Exact versions parsed as tilda (`--exact-as-tilda|-t`).
If you require package `"nella/victor": "1.0.0"` in your `composer.json`.
_Victor_ parse this as `~1.0.0`.

```
php victor.phar show -t
```

## Note

A huge thank you goes to Verča Rašková for solving the biggest issue - the naming of the package.

## License

Victor is licensed under the MIT License - see the LICENSE file for details.

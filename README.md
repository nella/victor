# Victor - for [Composer](https://getcomposer.org)

Victor is a version updates checker for your composer package requirements.

## Instalation

```bash
wget https://github.com/nella/victor/releases/download/v1.0.0/victor.phar -O victor.phar
# or
curl -o victor.phar https://github.com/nella/victor/releases/download/v1.0.0/victor.phar
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
php victor.phar -f
```

## Note

A huge thank you goes to Verča Rašková for solving the biggest issue - the naming of the package.

## License

Victor is licensed under the MIT License - see the LICENSE file for details.

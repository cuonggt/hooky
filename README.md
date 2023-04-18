# hooky

<a name="introduction"></a>
## Introduction

**Hooky** is an opinionated git hooks tool for PHP artisan. Hooky is heavily inspired of **[husky](https://github.com/typicode/husky)** and make it simple to **lint your commit messages**, **lint code**, **run tests**, etc... when you commit or push.

<a name="installation"></a>
## Installation

First, install Hooky into your project using the Composer package manager:

```sh
composer require --dev cuonggt/hooky
```

Then run the install command:

```sh
vendor/bin/hooky install
```

<a name="usage"></a>
## Usage

Add a hook:

```sh
vendor/bin/hooky add .hooky/pre-commit "vendor/bin/phpunit"
```

Make a commit:

```sh
git add .hooky/pre-commit
git commit -m "Keep calm and commit"
# `vendor/bin/phpunit` will run
```

<a name="license"></a>
## License

Hooky is open-sourced software licensed under the [MIT license](LICENSE.md).

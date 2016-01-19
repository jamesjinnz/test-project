# Catalyst Test Project

Catalyst Test Project
This documentation below for more information.

## Quick Start

Use [test-project](https://github.com/jamesjinnz/test-project.git) to get started with a development.

## Requirements

* Git
* PHP >= 5.5.9 (for Composer)
* You need the mbstring extension to use Csv (league/csv) package

## Installation/Usage

See [Documentation](#documentation) for more details on the steps below.

1. Clone/Fork repo (https://github.com/jamesjinnz/test-project.git)
2. Run `composer install`
3. Copy `.env.example` to `.env` and update environment variables:
    * `DB_NAME` - Database name
    * `DB_USER` - Database user
    * `DB_PASSWORD` - Database password
    * `DB_HOST` - Database host (defaults to `localhost`)

## Documentation

### Folder Structure

```
├── config
│   ├── setting.php
│   └── app.php
├── Entity
│   ├── resCommon.php
│   ├── setting.php
│   └── UserRes.php
├── Library
│   └── csvHandler.php
├── .env.example
├── .gitignore
├── composer.json
├── composer.lock
├── README.md
└── user_upload.php
```
### Composer
[Composer](http://getcomposer.org) is used to manage dependencies.

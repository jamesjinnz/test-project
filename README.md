# Catalyst Test Project
tttttt
Catalyst Test Project
This documentation below for more information.

## Quick Start

Use [test-project](https://github.com/jamesjinnz/test-project.git) to get started with a development.

## Requirements

* Git
* PHP >= 5.5.9 (for Composer)
* Composer [Composer](http://getcomposer.org) is used to manage dependencies.
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
In the [Config/Setting.php], public $debug = false; 
It mean turn off the error report and disable to show more exporting info.
When change it to public $debug = true;  system will verbose exporting detail and turn on all the error report.

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

### Command Cli

```
[Flags]
    *  --help          Show this help screen
    *  --create_table  this will cause the MySQL users table to be built (and no further action will be taken)
    *  --dry_run       this will be used with the --file directive in the instance that we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered.

[Options] Option argument, after it need put space and input your value
    *  --file  [csv file name] – this is the name of the CSV to be parsed 
    *  --u     MySQL username
    *  --p     MySQL password
    *  --h     MySQL host
    *  --d     MySQL database
```    

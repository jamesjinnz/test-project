<?php
require(dirname(__FILE__) . '/Config/app.php');

if (php_sapi_name() != "cli") {
    die('CLI command');
}

if ($argc < 2) {
    die("Please type argument or type --help to find detail of usage.\n");
}

$app->console->load();
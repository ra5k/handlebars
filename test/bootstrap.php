<?php
/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Define some paths
define('TEST_PATH', realpath(__DIR__));
define('APPLICATION_PATH', realpath(__DIR__ . "/.."));
define('SCRIPT_PATH', TEST_PATH . "/scripts");
define('CACHE_PATH', TEST_PATH . "/cache");

// Register the autoloader
$loader = require APPLICATION_PATH . "/vendor/autoload.php";

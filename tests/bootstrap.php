<?php
// Set timezone
date_default_timezone_set('America/New_York');

// Prevent session cookies
ini_set('session.use_cookies', 0);

// Enable Composer autoloader
$autoloader = require dirname(__DIR__) . '/vendor/autoload.php';

// Register actions
require dirname(__DIR__) . '/actions/BuildActions.php';

// Register services
require dirname(__DIR__) . '/services/AppFactory.php';

require dirname(__FILE__) . '/ContainerTestHelper.php';
require dirname(__FILE__) . '/ActionsTestHelper.php';
require dirname(__FILE__) . '/DirectoryAssertHelper.php';

// Register test classes
$autoloader->addPsr4('tests\\', __DIR__);
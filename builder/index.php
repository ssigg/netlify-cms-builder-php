<?php

// Composer libraries
require '../vendor/autoload.php';

// App factory
require '../services/AppFactory.php';

// Actions
require '../actions/BuildActions.php';

$app = Services\AppFactory::createForProduction(__DIR__);

// Routes
// =============================================================
$app->post('/build', Actions\BuildAllAction::class);
// =============================================================

$app->run();
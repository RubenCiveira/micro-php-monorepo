<?php
use Civi\Micro\Context;
use Civi\Micro\WebContext;

require __DIR__ . '/../../vendor/autoload.php';

Context::registerDefinitions(require '../../resources/starter/definitions.php');
Context::registerDefinitions(require '../../resources/starter/services/definitions.php');

$context = new WebContext('../../', dirname($_SERVER['SCRIPT_NAME']));
$context->start( require '../../resources/starter/services/routes.php' );

<?php
use Civi\Micro\Context;
use Civi\Micro\WebContext;

require __DIR__ . '/../vendor/autoload.php';

Context::registerDefinitions(require '../resources/starter/hosts/definitions.php');

$context = new WebContext(dirname($_SERVER['SCRIPT_NAME']));
if( !is_dir('../.cache') ) {
    mkdir('../.cache');
}
$context->cache('../.cache');
$context->start( require '../resources/starter/hosts/routes.php' );

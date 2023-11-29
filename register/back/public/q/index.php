<?php
use Civi\Micro\Profile;
use Civi\Micro\WebContext;

require __DIR__ . '/../../vendor/autoload.php';

Profile::run( new WebContext('../../', dirname($_SERVER['SCRIPT_NAME'])));

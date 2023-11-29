<?php

namespace Ray\Di\Compiler;

$instance = new \Civi\Micro\Migration\MigrationService($prototype('PDO-', array('Civi\\Micro\\Migration\\MigrationService', '__construct', 'pdo')), $injector());
$isSingleton = false;
return $instance;

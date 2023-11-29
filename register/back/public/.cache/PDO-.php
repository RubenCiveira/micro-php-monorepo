<?php

namespace Ray\Di\Compiler;

$instance = new \Civi\Micro\Impl\Sql\PdoBuilder($injectionPoint(), $prototype('Civi\\Micro\\Enviroment-'));
$isSingleton = false;
return $instance->get();

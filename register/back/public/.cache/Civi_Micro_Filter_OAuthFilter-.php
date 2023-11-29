<?php

namespace Ray\Di\Compiler;

$instance = new \Civi\Micro\Filter\OAuthFilter($prototype('Civi\\Micro\\Jwt\\TokenVerifier-', array('Civi\\Micro\\Filter\\OAuthFilter', '__construct', 'verifier')));
$isSingleton = false;
return $instance;

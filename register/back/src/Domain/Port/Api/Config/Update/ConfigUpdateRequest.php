<?php
namespace Register\Domain\Port\Api\Config\Update;

use Register\Domain\Model\Query\ConfigRef;
use Register\Domain\Model\Config;

class ConfigUpdateRequest {
  public function __construct(public readonly ?ConfigRef $ref,
          public readonly Config $entity){}
}

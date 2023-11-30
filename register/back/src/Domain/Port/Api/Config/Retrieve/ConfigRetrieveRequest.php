<?php
namespace Register\Domain\Port\Api\Config\Retrieve;

use Register\Domain\Model\Ref\ConfigRef;

class ConfigRetrieveRequest {
  public function __construct(public readonly ConfigRef $ref){}
}

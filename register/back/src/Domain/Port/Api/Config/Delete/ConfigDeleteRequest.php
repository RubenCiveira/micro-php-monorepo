<?php
namespace Register\Domain\Port\Api\Config\Delete;

use Register\Domain\Model\Ref\ConfigRef;

class ConfigDeleteRequest {
  public function __construct(public readonly ConfigRef $ref){}
}

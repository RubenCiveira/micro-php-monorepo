<?php
namespace Register\Domain\Port\Api\Config\Delete;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ConfigRef;

class ConfigDeleteRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ConfigRef $ref){}
}

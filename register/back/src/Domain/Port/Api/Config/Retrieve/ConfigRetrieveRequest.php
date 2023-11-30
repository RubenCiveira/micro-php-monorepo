<?php
namespace Register\Domain\Port\Api\Config\Retrieve;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ConfigRef;

class ConfigRetrieveRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ConfigRef $ref){}
}

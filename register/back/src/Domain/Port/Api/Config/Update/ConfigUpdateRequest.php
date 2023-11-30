<?php
namespace Register\Domain\Port\Api\Config\Update;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ConfigRef;
use Register\Domain\Model\Config;

class ConfigUpdateRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ConfigRef $ref,
          public readonly Config $entity){}
}

<?php
namespace Register\Domain\Port\Api\Config\Create;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Config;

class ConfigCreateRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly Config $entity){}
}

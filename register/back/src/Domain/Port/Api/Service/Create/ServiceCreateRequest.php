<?php
namespace Register\Domain\Port\Api\Service\Create;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Service;

class ServiceCreateRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly Service $entity){}
}

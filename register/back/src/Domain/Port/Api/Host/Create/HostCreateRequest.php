<?php
namespace Register\Domain\Port\Api\Host\Create;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Host;

class HostCreateRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly Host $entity){}
}

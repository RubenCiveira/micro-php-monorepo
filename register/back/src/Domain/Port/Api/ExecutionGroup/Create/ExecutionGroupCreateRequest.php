<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Create;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\ExecutionGroup;

class ExecutionGroupCreateRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ExecutionGroup $entity){}
}

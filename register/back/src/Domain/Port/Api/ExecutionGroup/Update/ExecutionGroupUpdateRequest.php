<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Update;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ExecutionGroupRef;
use Register\Domain\Model\ExecutionGroup;

class ExecutionGroupUpdateRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ExecutionGroupRef $ref,
          public readonly ExecutionGroup $entity){}
}

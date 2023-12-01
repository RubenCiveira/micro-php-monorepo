<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Retrieve;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ExecutionGroupRef;

class ExecutionGroupRetrieveRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ExecutionGroupRef $ref){}
}

<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Delete;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ExecutionGroupRef;

class ExecutionGroupDeleteRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ExecutionGroupRef $ref){}
}

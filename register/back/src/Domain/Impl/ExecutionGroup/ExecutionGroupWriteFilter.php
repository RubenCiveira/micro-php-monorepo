<?php
namespace Register\Domain\Impl\ExecutionGroup;

use Register\Domain\Model\ExecutionGroup;
use Register\Domain\Model\Security\ActorRequest;

class ExecutionGroupWriteFilter {
  public function transformFromInput(ActorRequest $actor, ExecutionGroup $value): ExecutionGroup {
    return $value;  }
}

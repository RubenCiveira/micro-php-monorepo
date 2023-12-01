<?php
namespace Register\Domain\Impl\ExecutionGroup;

use Register\Domain\Model\ExecutionGroup;
use Register\Domain\Model\Security\ActorRequest;

class ExecutionGroupReadFilter {
  public function transformToOutput(ActorRequest $actor, ExecutionGroup $value): ExecutionGroup {
    return $value;
  }
}

<?php
namespace Register\Domain\Impl\ExecutionGroup;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\ExecutionGroupFilter;

class ExecutionGroupVisibilityFilter {
  public function buildFilter(ActorRequest $actor, ExecutionGroupFilter $filter): ExecutionGroupFilter {
    return $filter;
  }
}

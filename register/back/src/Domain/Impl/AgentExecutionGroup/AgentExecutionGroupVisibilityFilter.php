<?php
namespace Register\Domain\Impl\AgentExecutionGroup;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\AgentExecutionGroupFilter;

class AgentExecutionGroupVisibilityFilter {
  public function buildFilter(ActorRequest $actor, AgentExecutionGroupFilter $filter): AgentExecutionGroupFilter {
    return $filter;
  }
}

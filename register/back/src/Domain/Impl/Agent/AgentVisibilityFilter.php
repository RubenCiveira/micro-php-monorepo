<?php
namespace Register\Domain\Impl\Agent;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\AgentFilter;

class AgentVisibilityFilter {
  public function buildFilter(ActorRequest $actor, AgentFilter $filter): AgentFilter {
    return $filter;
  }
}

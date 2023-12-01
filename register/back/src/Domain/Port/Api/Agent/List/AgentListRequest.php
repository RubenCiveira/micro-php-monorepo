<?php
namespace Register\Domain\Port\Api\Agent\List;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\AgentFilter;
use Register\Domain\Model\Query\AgentSort;

class AgentListRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly AgentFilter $filter,
          public readonly AgentSort $sort){}
}

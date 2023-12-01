<?php
namespace Register\Domain\Port\Api\ExecutionGroup\List;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\ExecutionGroupFilter;
use Register\Domain\Model\Query\ExecutionGroupSort;

class ExecutionGroupListRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ExecutionGroupFilter $filter,
          public readonly ExecutionGroupSort $sort){}
}

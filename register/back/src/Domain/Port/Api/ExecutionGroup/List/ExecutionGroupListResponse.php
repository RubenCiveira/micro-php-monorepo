<?php
namespace Register\Domain\Port\Api\ExecutionGroup\List;

use Register\Domain\Model\ExecutionGroup;
use Register\Domain\Model\List\ExecutionGroupList;

class ExecutionGroupListResponse {
  public function __construct(public readonly ExecutionGroupList $data,
          public readonly ?ExecutionGroup $next){}
}

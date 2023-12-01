<?php
namespace Register\Domain\Port\Api\ExecutionGroup\List;

use Register\Domain\Model\ExecutionGroup;

class ExecutionGroupListResponse {
  public function __construct(public readonly array $data,
          public readonly ?ExecutionGroup $next){}
}

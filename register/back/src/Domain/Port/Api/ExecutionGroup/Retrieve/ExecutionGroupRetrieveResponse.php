<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Retrieve;

use Register\Domain\Model\ExecutionGroup;

class ExecutionGroupRetrieveResponse {
  public function __construct(public readonly ?ExecutionGroup $data){}
}

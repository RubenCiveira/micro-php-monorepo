<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Update;

use Register\Domain\Model\ExecutionGroup;

class ExecutionGroupUpdateResponse {
  public function __construct(public readonly ?ExecutionGroup $data){}
}

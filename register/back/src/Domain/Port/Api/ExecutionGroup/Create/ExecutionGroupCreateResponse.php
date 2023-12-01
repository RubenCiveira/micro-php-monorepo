<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Create;

use Register\Domain\Model\ExecutionGroup;

class ExecutionGroupCreateResponse {
  public function __construct(public readonly ?ExecutionGroup $data){}
}

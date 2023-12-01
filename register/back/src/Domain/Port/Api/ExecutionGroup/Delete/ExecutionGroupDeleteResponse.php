<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Delete;


class ExecutionGroupDeleteResponse {
  public function __construct(public readonly bool $result){}
}

<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Retrieve;


interface ExecutionGroupRetrieveUseCase {
  public function retrieve(ExecutionGroupRetrieveRequest $request): ExecutionGroupRetrieveResponse;
}

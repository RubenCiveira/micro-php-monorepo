<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Create;


interface ExecutionGroupCreateUseCase {
  public function create(ExecutionGroupCreateRequest $request): ExecutionGroupCreateResponse;
}

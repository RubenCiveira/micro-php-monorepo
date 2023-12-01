<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Update;


interface ExecutionGroupUpdateUseCase {
  public function update(ExecutionGroupUpdateRequest $request): ExecutionGroupUpdateResponse;
}

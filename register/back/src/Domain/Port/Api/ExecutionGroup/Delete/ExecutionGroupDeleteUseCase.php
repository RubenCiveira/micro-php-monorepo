<?php
namespace Register\Domain\Port\Api\ExecutionGroup\Delete;


interface ExecutionGroupDeleteUseCase {
  public function delete(ExecutionGroupDeleteRequest $request): ExecutionGroupDeleteResponse;
}

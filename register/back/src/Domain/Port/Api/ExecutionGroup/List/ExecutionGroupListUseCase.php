<?php
namespace Register\Domain\Port\Api\ExecutionGroup\List;


interface ExecutionGroupListUseCase {
  public function list(ExecutionGroupListRequest $request): ExecutionGroupListResponse;
}

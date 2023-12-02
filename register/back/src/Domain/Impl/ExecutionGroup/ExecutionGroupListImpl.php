<?php
namespace Register\Domain\Impl\ExecutionGroup;


use Register\Domain\Port\Api\ExecutionGroup\List\ExecutionGroupListUseCase;
use Register\Domain\Port\Api\ExecutionGroup\List\ExecutionGroupListRequest;
use Register\Domain\Port\Api\ExecutionGroup\List\ExecutionGroupListResponse;
use Register\Domain\Port\Spi\ExecutionGroup\ExecutionGroupRepository;

class ExecutionGroupListImpl implements ExecutionGroupListUseCase {
  public function __construct(private readonly ExecutionGroupRepository $repository,
            private readonly ExecutionGroupVisibilityFilter $visibilityFilter,
           private readonly ExecutionGroupReadFilter $readFilter) {}
  public function list(ExecutionGroupListRequest $request): ExecutionGroupListResponse {
    $result = $this->repository->list( $this->visibilityFilter->buildFilter($request->actor, $request->filter), $request->sort);    return new ExecutionGroupListResponse(data: $result->map( fn($row) => $this->readFilter->transformToOutput($request->actor, $row)), next: null);
  }
}

<?php
namespace Register\Domain\Impl\ExecutionGroup;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ExecutionGroupFilter;
use Register\Domain\Port\Api\ExecutionGroup\Delete\ExecutionGroupDeleteUseCase;
use Register\Domain\Port\Api\ExecutionGroup\Delete\ExecutionGroupDeleteRequest;
use Register\Domain\Port\Api\ExecutionGroup\Delete\ExecutionGroupDeleteResponse;
use Register\Domain\Port\Spi\ExecutionGroup\ExecutionGroupRepository;

class ExecutionGroupDeleteImpl implements ExecutionGroupDeleteUseCase {
  public function __construct(private readonly ExecutionGroupRepository $repository,
            private readonly ExecutionGroupVisibilityFilter $visibilityFilter) {}
  public function delete(ExecutionGroupDeleteRequest $request): ExecutionGroupDeleteResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, ExecutionGroupFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $result = $this->repository->delete($request->ref);
    return new ExecutionGroupDeleteResponse(result: $result);
  }
}

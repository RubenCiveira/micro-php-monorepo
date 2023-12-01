<?php
namespace Register\Domain\Impl\ExecutionGroup;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ExecutionGroupFilter;
use Register\Domain\Port\Api\ExecutionGroup\Retrieve\ExecutionGroupRetrieveUseCase;
use Register\Domain\Port\Api\ExecutionGroup\Retrieve\ExecutionGroupRetrieveRequest;
use Register\Domain\Port\Api\ExecutionGroup\Retrieve\ExecutionGroupRetrieveResponse;
use Register\Domain\Port\Spi\ExecutionGroup\ExecutionGroupRepository;

class ExecutionGroupRetrieveImpl implements ExecutionGroupRetrieveUseCase {
  public function __construct(private readonly ExecutionGroupRepository $repository,
            private readonly ExecutionGroupVisibilityFilter $visibilityFilter,
           private readonly ExecutionGroupReadFilter $readFilter) {}
  public function retrieve(ExecutionGroupRetrieveRequest $request): ExecutionGroupRetrieveResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, ExecutionGroupFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $finded = $this->repository->retrieve($request->ref);
    return new ExecutionGroupRetrieveResponse(data: $this->readFilter->transformToOutput($request->actor, $finded) );
  }
}

<?php
namespace Register\Domain\Impl\ExecutionGroup;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ExecutionGroupFilter;
use Register\Domain\Port\Api\ExecutionGroup\Create\ExecutionGroupCreateUseCase;
use Register\Domain\Port\Api\ExecutionGroup\Create\ExecutionGroupCreateRequest;
use Register\Domain\Port\Api\ExecutionGroup\Create\ExecutionGroupCreateResponse;
use Register\Domain\Port\Spi\ExecutionGroup\ExecutionGroupRepository;

class ExecutionGroupCreateImpl implements ExecutionGroupCreateUseCase {
  public function __construct(private readonly ExecutionGroupRepository $repository,
            private readonly ExecutionGroupVisibilityFilter $visibilityFilter,
           private readonly ExecutionGroupReadFilter $readFilter,
           private readonly ExecutionGroupWriteFilter $writeFilter) {}
  public function create(ExecutionGroupCreateRequest $request): ExecutionGroupCreateResponse {
    $created = $this->repository->create($this->writeFilter->transformFromInput($request->actor, $request->entity) );
    if( !$this->repository->exists($created, $this->visibilityFilter->buildFilter($request->actor, ExecutionGroupFilter::builder()->build()) ) ) {
        $this->repository->delete( $created );
        throw new NotFoundException($request->ref->uid);
    }
    return new ExecutionGroupCreateResponse(data: $this->readFilter->transformToOutput($request->actor, $created) );
  }
}

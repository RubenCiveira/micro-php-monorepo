<?php
namespace Register\Domain\Impl\ExecutionGroup;

use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ExecutionGroupFilter;
use Register\Domain\Port\Api\ExecutionGroup\Update\ExecutionGroupUpdateUseCase;
use Register\Domain\Port\Api\ExecutionGroup\Update\ExecutionGroupUpdateRequest;
use Register\Domain\Port\Api\ExecutionGroup\Update\ExecutionGroupUpdateResponse;
use Register\Domain\Port\Spi\ExecutionGroup\ExecutionGroupRepository;

class ExecutionGroupUpdateImpl implements ExecutionGroupUpdateUseCase {
  public function __construct(private readonly ExecutionGroupRepository $repository,
            private readonly ExecutionGroupVisibilityFilter $visibilityFilter,
           private readonly ExecutionGroupReadFilter $readFilter,
           private readonly ExecutionGroupWriteFilter $writeFilter) {}
  public function update(ExecutionGroupUpdateRequest $request): ExecutionGroupUpdateResponse {
    $original = $this->repository->retrieve($request->ref, $this->visibilityFilter->buildFilter($request->actor, ExecutionGroupFilter::builder()->build()) );
    if( !$original ) {
        throw new NotFoundException($request->ref->uid);
    }
    if( $request->ref->uid !== $request->entity->uid) {
        throw new OptimistLockException($request->ref->uid, $request->entity->uid);
    }
    $updated = $this->repository->update($this->writeFilter->transformFromInput($request->actor, $request->entity));
    return new ExecutionGroupUpdateResponse(data: $this->readFilter->transformToOutput($request->actor, $updated) );
  }
}

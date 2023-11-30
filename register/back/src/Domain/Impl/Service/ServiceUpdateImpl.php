<?php
namespace Register\Domain\Impl\Service;

use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ServiceFilter;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateUseCase;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateRequest;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceUpdateImpl implements ServiceUpdateUseCase {
  public function __construct(private readonly ServiceRepository $repository,
            private readonly ServiceVisibilityFilter $visibilityFilter,
           private readonly ServiceReadFilter $readFilter,
           private readonly ServiceWriteFilter $writeFilter) {}
  public function update(ServiceUpdateRequest $request): ServiceUpdateResponse {
    if( !$this->repository->exists($request->ref, $this->visibilityFilter->buildFilter($request->actor, ServiceFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    if( $request->ref->uid !== $request->entity->uid) {
        throw new OptimistLockException($request->ref->uid, $request->entity->uid);
    }
    $updated = $this->repository->update($this->writeFilter->transformFromInput($request->actor, $request->entity));
    return new ServiceUpdateResponse(data: $this->readFilter->transformToOutput($request->actor, $updated) );
  }
}

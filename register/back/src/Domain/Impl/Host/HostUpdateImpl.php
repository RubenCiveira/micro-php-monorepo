<?php
namespace Register\Domain\Impl\Host;

use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\HostFilter;use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Host\Update\HostUpdateUseCase;
use Register\Domain\Port\Api\Host\Update\HostUpdateRequest;
use Register\Domain\Port\Api\Host\Update\HostUpdateResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostUpdateImpl implements HostUpdateUseCase {
  public function __construct(private readonly HostRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly HostVisibilityFilter $visibilityFilter,
           private readonly HostReadFilter $readFilter,
           private readonly HostWriteFilter $writeFilter) {}
  public function update(HostUpdateRequest $request): HostUpdateResponse {
    $original = $this->repository->retrieve($request->ref, $this->visibilityFilter->buildFilter($request->actor, HostFilter::builder()->build()) );
    if( !$original ) {
        throw new NotFoundException($request->ref->uid);
    }
    if( $request->entity->service && !$this->serviceRepository->exists($request->entity->service, $this->serviceVisibility->buildFilter($request->actor, ServiceFilter::builder()->build()) )  ) {
        throw new NotFoundException($request->entity->service->uid);
    }
    if( $request->ref->uid !== $request->entity->uid) {
        throw new OptimistLockException($request->ref->uid, $request->entity->uid);
    }
    $updated = $this->repository->update($this->writeFilter->transformFromInput($request->actor, $request->entity));
    return new HostUpdateResponse(data: $this->readFilter->transformToOutput($request->actor, $updated) );
  }
}

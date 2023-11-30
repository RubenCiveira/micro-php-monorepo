<?php
namespace Register\Domain\Impl\Host;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\HostFilter;use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Host\Create\HostCreateUseCase;
use Register\Domain\Port\Api\Host\Create\HostCreateRequest;
use Register\Domain\Port\Api\Host\Create\HostCreateResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostCreateImpl implements HostCreateUseCase {
  public function __construct(private readonly HostRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly HostVisibilityFilter $visibilityFilter,
           private readonly HostReadFilter $readFilter,
           private readonly HostWriteFilter $writeFilter) {}
  public function create(HostCreateRequest $request): HostCreateResponse {
    if( $request->entity->service && !$this->serviceRepository->exists($request->entity->service, $this->serviceVisibility->buildFilter($request->actor, ServiceFilter::builder()->build()) )  ) {
        throw new NotFoundException($request->entity->service->uid);
    }
    $created = $this->repository->create($this->writeFilter->transformFromInput($request->actor, $request->entity) );
    if( !$this->repository->exists($created, $this->visibilityFilter->buildFilter($request->actor, HostFilter::builder()->build()) ) ) {
        $this->repository->delete( $created );
        throw new NotFoundException($request->ref->uid);
    }
    return new HostCreateResponse(data: $this->readFilter->transformToOutput($request->actor, $created) );
  }
}

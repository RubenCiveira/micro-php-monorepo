<?php
namespace Register\Domain\Impl\Host;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\HostFilter;use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveUseCase;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveRequest;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostRetrieveImpl implements HostRetrieveUseCase {
  public function __construct(private readonly HostRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly HostVisibilityFilter $visibilityFilter,
           private readonly HostReadFilter $readFilter) {}
  public function retrieve(HostRetrieveRequest $request): HostRetrieveResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, HostFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $finded = $this->repository->retrieve($request->ref);
    return new HostRetrieveResponse(data: $this->readFilter->transformToOutput($request->actor, $finded) );
  }
}

<?php
namespace Register\Domain\Impl\Service;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ServiceFilter;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveUseCase;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveRequest;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceRetrieveImpl implements ServiceRetrieveUseCase {
  public function __construct(private readonly ServiceRepository $repository,
            private readonly ServiceVisibilityFilter $visibilityFilter,
           private readonly ServiceReadFilter $readFilter) {}
  public function retrieve(ServiceRetrieveRequest $request): ServiceRetrieveResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, ServiceFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $finded = $this->repository->retrieve($request->ref);
    return new ServiceRetrieveResponse(data: $this->readFilter->transformToOutput($request->actor, $finded) );
  }
}

<?php
namespace Register\Domain\Impl\Service;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ServiceFilter;
use Register\Domain\Port\Api\Service\Create\ServiceCreateUseCase;
use Register\Domain\Port\Api\Service\Create\ServiceCreateRequest;
use Register\Domain\Port\Api\Service\Create\ServiceCreateResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceCreateImpl implements ServiceCreateUseCase {
  public function __construct(private readonly ServiceRepository $repository,
            private readonly ServicePropertiesCalculator $propertiesCalculator,
            private readonly ServiceVisibilityFilter $visibilityFilter,
           private readonly ServiceReadFilter $readFilter,
           private readonly ServiceWriteFilter $writeFilter) {}
  public function create(ServiceCreateRequest $request): ServiceCreateResponse {
    $created = $this->repository->create($this->writeFilter->transformFromInput($request->actor, $this->propertiesCalculator->calculateProperties($request->actor, $request->entity ) ) );
    if( !$this->repository->exists($created, $this->visibilityFilter->buildFilter($request->actor, ServiceFilter::builder()->build()) ) ) {
        $this->repository->delete( $created );
        throw new NotFoundException($request->ref->uid);
    }
    return new ServiceCreateResponse(data: $this->readFilter->transformToOutput($request->actor, $created) );
  }
}

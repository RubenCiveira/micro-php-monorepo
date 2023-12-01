<?php
namespace Register\Domain\Impl\Service;


use Register\Domain\Port\Api\Service\Disable\ServiceDisableUseCase;
use Register\Domain\Port\Api\Service\Disable\ServiceDisableRequest;
use Register\Domain\Port\Api\Service\Disable\ServiceDisableResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceDisableImpl implements ServiceDisableUseCase {
  public function __construct(private readonly ServiceRepository $repository,
            private readonly ServiceVisibilityFilter $visibilityFilter) {}
  public function disable(ServiceDisableRequest $request): ServiceDisableResponse {
    $original = $this->repository->retrieve($request->ref, $this->visibilityFilter->buildFilter($request->actor, ServiceFilter::builder()->build()) );
    if( !$original ) {
        throw new NotFoundException($request->ref->uid);
    }
    $entity = $original->toBuilder()->enabled(false)->build();
    $updated = $this->repository->update($this->writeFilter->transformFromInput($request->actor, $this->propertiesCalculator->calculateProperties($request->actor, $entity, $original ) ));
    return new ServiceDisableResponse(data: $this->readFilter->transformToOutput($request->actor, $updated) );
  }
}

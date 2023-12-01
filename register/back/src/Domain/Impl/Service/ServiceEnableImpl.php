<?php
namespace Register\Domain\Impl\Service;


use Register\Domain\Port\Api\Service\Enable\ServiceEnableUseCase;
use Register\Domain\Port\Api\Service\Enable\ServiceEnableRequest;
use Register\Domain\Port\Api\Service\Enable\ServiceEnableResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceEnableImpl implements ServiceEnableUseCase {
  public function __construct(private readonly ServiceRepository $repository,
            private readonly ServiceVisibilityFilter $visibilityFilter) {}
  public function enable(ServiceEnableRequest $request): ServiceEnableResponse {
    $original = $this->repository->retrieve($request->ref, $this->visibilityFilter->buildFilter($request->actor, ServiceFilter::builder()->build()) );
    if( !$original ) {
        throw new NotFoundException($request->ref->uid);
    }
    $entity = $original->toBuilder()->enabled(true)->build();
    $updated = $this->repository->update($this->writeFilter->transformFromInput($request->actor, $this->propertiesCalculator->calculateProperties($request->actor, $entity, $original ) ));
    return new ServiceEnableResponse(data: $this->readFilter->transformToOutput($request->actor, $updated) );
  }
}

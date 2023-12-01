<?php
namespace Register\Domain\Impl\Service;


use Register\Domain\Port\Api\Service\ActionDisable\ServiceActionDisableUseCase;
use Register\Domain\Port\Api\Service\ActionDisable\ServiceActionDisableRequest;
use Register\Domain\Port\Api\Service\ActionDisable\ServiceActionDisableResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceActionDisableImpl implements ServiceActionDisableUseCase {
  public function __construct(private readonly ServiceRepository $repository,
            private readonly ServicePropertiesCalculator $propertiesCalculator,
            private readonly ServiceVisibilityFilter $visibilityFilter,
           private readonly ServiceReadFilter $readFilter) {}
  public function actionDisable(ServiceActionDisableRequest $request): ServiceActionDisableResponse {
    $original = $this->repository->retrieve($request->ref, $this->visibilityFilter->buildFilter($request->actor, ServiceFilter::builder()->build()) );
    if( !$original ) {
        throw new NotFoundException($request->ref->uid);
    }
    $entity = $original->toBuilder()->enabled(false)->build();
    $updated = $this->repository->update($this->writeFilter->transformFromInput($request->actor, $this->propertiesCalculator->calculateProperties($request->actor, $entity, $original ) ));
    return new ServiceActionDisableResponse(data: $this->readFilter->transformToOutput($request->actor, $updated) );
  }
}

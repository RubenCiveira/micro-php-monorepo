<?php
namespace Register\Domain\Impl\Service;


use Register\Domain\Port\Api\Service\ActionEnable\ServiceActionEnableUseCase;
use Register\Domain\Port\Api\Service\ActionEnable\ServiceActionEnableRequest;
use Register\Domain\Port\Api\Service\ActionEnable\ServiceActionEnableResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceActionEnableImpl implements ServiceActionEnableUseCase {
  public function __construct(private readonly ServiceRepository $repository,
            private readonly ServicePropertiesCalculator $propertiesCalculator,
            private readonly ServiceVisibilityFilter $visibilityFilter,
           private readonly ServiceReadFilter $readFilter) {}
  public function actionEnable(ServiceActionEnableRequest $request): ServiceActionEnableResponse {
    $original = $this->repository->retrieve($request->ref, $this->visibilityFilter->buildFilter($request->actor, ServiceFilter::builder()->build()) );
    if( !$original ) {
        throw new NotFoundException($request->ref->uid);
    }
    $entity = $original->toBuilder()->enabled(true)->build();
    $updated = $this->repository->update($this->writeFilter->transformFromInput($request->actor, $this->propertiesCalculator->calculateProperties($request->actor, $entity, $original ) ));
    return new ServiceActionEnableResponse(data: $this->readFilter->transformToOutput($request->actor, $updated) );
  }
}

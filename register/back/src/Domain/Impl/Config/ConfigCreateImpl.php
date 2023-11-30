<?php
namespace Register\Domain\Impl\Config;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ConfigFilter;use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Config\Create\ConfigCreateUseCase;
use Register\Domain\Port\Api\Config\Create\ConfigCreateRequest;
use Register\Domain\Port\Api\Config\Create\ConfigCreateResponse;
use Register\Domain\Port\Spi\Config\ConfigRepository;

class ConfigCreateImpl implements ConfigCreateUseCase {
  public function __construct(private readonly ConfigRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly ConfigVisibilityFilter $visibilityFilter,
           private readonly ConfigReadFilter $readFilter,
           private readonly ConfigWriteFilter $writeFilter) {}
  public function create(ConfigCreateRequest $request): ConfigCreateResponse {
    if( $request->entity->service && !$this->serviceRepository->exists($request->entity->service, $this->serviceVisibility->buildFilter($request->actor, ServiceFilter::builder()->build()) )  ) {
        throw new NotFoundException($request->entity->service->uid);
    }
    $created = $this->repository->create($this->writeFilter->transformFromInput($request->actor, $request->entity) );
    if( !$this->repository->exists($created, $this->visibilityFilter->buildFilter($request->actor, ConfigFilter::builder()->build()) ) ) {
        $this->repository->delete( $created );
        throw new NotFoundException($request->ref->uid);
    }
    return new ConfigCreateResponse(data: $this->readFilter->transformToOutput($request->actor, $created) );
  }
}

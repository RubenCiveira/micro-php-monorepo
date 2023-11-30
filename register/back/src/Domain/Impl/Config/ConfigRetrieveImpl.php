<?php
namespace Register\Domain\Impl\Config;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ConfigFilter;use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveUseCase;
use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveRequest;
use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveResponse;
use Register\Domain\Port\Spi\Config\ConfigRepository;

class ConfigRetrieveImpl implements ConfigRetrieveUseCase {
  public function __construct(private readonly ConfigRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly ConfigVisibilityFilter $visibilityFilter,
           private readonly ConfigReadFilter $readFilter) {}
  public function retrieve(ConfigRetrieveRequest $request): ConfigRetrieveResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, ConfigFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $finded = $this->repository->retrieve($request->ref);
    return new ConfigRetrieveResponse(data: $this->readFilter->transformToOutput($request->actor, $finded) );
  }
}

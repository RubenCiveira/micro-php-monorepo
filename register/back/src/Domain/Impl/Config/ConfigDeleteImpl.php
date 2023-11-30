<?php
namespace Register\Domain\Impl\Config;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ConfigFilter;use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Config\Delete\ConfigDeleteUseCase;
use Register\Domain\Port\Api\Config\Delete\ConfigDeleteRequest;
use Register\Domain\Port\Api\Config\Delete\ConfigDeleteResponse;
use Register\Domain\Port\Spi\Config\ConfigRepository;

class ConfigDeleteImpl implements ConfigDeleteUseCase {
  public function __construct(private readonly ConfigRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly ConfigVisibilityFilter $visibilityFilter) {}
  public function delete(ConfigDeleteRequest $request): ConfigDeleteResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, ConfigFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $result = $this->repository->delete($request->ref);
    return new ConfigDeleteResponse(result: $result);
  }
}

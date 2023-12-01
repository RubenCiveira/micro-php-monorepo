<?php
namespace Register\Domain\Impl\Config;

use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ConfigFilter;use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Config\Update\ConfigUpdateUseCase;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateRequest;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateResponse;
use Register\Domain\Port\Spi\Config\ConfigRepository;

class ConfigUpdateImpl implements ConfigUpdateUseCase {
  public function __construct(private readonly ConfigRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly ConfigVisibilityFilter $visibilityFilter,
           private readonly ConfigReadFilter $readFilter,
           private readonly ConfigWriteFilter $writeFilter) {}
  public function update(ConfigUpdateRequest $request): ConfigUpdateResponse {
    $original = $this->repository->retrieve($request->ref, $this->visibilityFilter->buildFilter($request->actor, ConfigFilter::builder()->build()) );
    if( !$original ) {
        throw new NotFoundException($request->ref->uid);
    }
    if( $request->entity->service && !$this->serviceRepository->exists($request->entity->service, $this->serviceVisibility->buildFilter($request->actor, ServiceFilter::builder()->build()) )  ) {
        throw new NotFoundException($request->entity->service->uid);
    }
    if( $request->ref->uid !== $request->entity->uid) {
        throw new OptimistLockException($request->ref->uid, $request->entity->uid);
    }
    $updated = $this->repository->update($this->writeFilter->transformFromInput($request->actor, $request->entity));
    return new ConfigUpdateResponse(data: $this->readFilter->transformToOutput($request->actor, $updated) );
  }
}

<?php
namespace Register\Domain\Impl\Config;

use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Config\List\ConfigListUseCase;
use Register\Domain\Port\Api\Config\List\ConfigListRequest;
use Register\Domain\Port\Api\Config\List\ConfigListResponse;
use Register\Domain\Port\Spi\Config\ConfigRepository;

class ConfigListImpl implements ConfigListUseCase {
  public function __construct(private readonly ConfigRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly ConfigVisibilityFilter $visibilityFilter,
           private readonly ConfigReadFilter $readFilter) {}
  public function list(ConfigListRequest $request): ConfigListResponse {
    $result = $this->repository->list( $this->visibilityFilter->buildFilter($request->actor, $request->filter), $request->sort);    return new ConfigListResponse(data: array_map( fn($row) => $this->readFilter->transformToOutput($request->actor, $row), $result), next: null);
  }
}

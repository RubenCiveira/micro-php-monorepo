<?php
namespace Register\Domain\Impl\Host;

use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Host\List\HostListUseCase;
use Register\Domain\Port\Api\Host\List\HostListRequest;
use Register\Domain\Port\Api\Host\List\HostListResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostListImpl implements HostListUseCase {
  public function __construct(private readonly HostRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly HostVisibilityFilter $visibilityFilter,
           private readonly HostReadFilter $readFilter) {}
  public function list(HostListRequest $request): HostListResponse {
    $result = $this->repository->list( $this->visibilityFilter->buildFilter($request->actor, $request->filter), $request->sort);    return new HostListResponse(data: array_map( fn($row) => $this->readFilter->transformToOutput($request->actor, $row), $result), next: null);
  }
}

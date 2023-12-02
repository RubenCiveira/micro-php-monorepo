<?php
namespace Register\Domain\Impl\Service;


use Register\Domain\Port\Api\Service\List\ServiceListUseCase;
use Register\Domain\Port\Api\Service\List\ServiceListRequest;
use Register\Domain\Port\Api\Service\List\ServiceListResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceListImpl implements ServiceListUseCase {
  public function __construct(private readonly ServiceRepository $repository,
            private readonly ServiceVisibilityFilter $visibilityFilter,
           private readonly ServiceReadFilter $readFilter) {}
  public function list(ServiceListRequest $request): ServiceListResponse {
    $result = $this->repository->list( $this->visibilityFilter->buildFilter($request->actor, $request->filter), $request->sort);    return new ServiceListResponse(data: $result->map( fn($row) => $this->readFilter->transformToOutput($request->actor, $row)), next: null);
  }
}

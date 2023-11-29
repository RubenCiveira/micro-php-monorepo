<?php
namespace Register\Domain\Impl\Service;

use Register\Domain\Port\Api\Service\List\ServiceListUseCase;
use Register\Domain\Port\Api\Service\List\ServiceListRequest;
use Register\Domain\Port\Api\Service\List\ServiceListResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceListImpl implements ServiceListUseCase {
  public function __construct(private readonly ServiceRepository $repository) {}
  public function List(ServiceListRequest $request): ServiceListResponse {
    return new ServiceListResponse(data: $this->repository->list($request->filter, $request->sort), next: null);
  }
}

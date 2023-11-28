<?php
namespace Register\Domain\Impl\Service;

use Register\Doamin\Port\Api\Service\Retrieve\ServiceRetrieveUseCase;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveRequest;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveResponse;
use Register\Port\Spi\Service\ServiceRepository;

class ServiceRetrieveImpl implements ServiceRetrieveUseCase {
  public function __construct(private readonly ServiceRepository $repository) {}
  public function Retrieve(ServiceRetrieveRequest $request): ServiceRetrieveResponse {
    return new ServiceListResponse();
  }
}

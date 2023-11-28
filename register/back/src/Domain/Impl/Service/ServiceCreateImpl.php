<?php
namespace Register\Domain\Impl\Service;

use Register\Doamin\Port\Api\Service\Create\ServiceCreateUseCase;
use Register\Domain\Port\Api\Service\Create\ServiceCreateRequest;
use Register\Domain\Port\Api\Service\Create\ServiceCreateResponse;
use Register\Port\Spi\Service\ServiceRepository;

class ServiceCreateImpl implements ServiceCreateUseCase {
  public function __construct(private readonly ServiceRepository $repository) {}
  public function Create(ServiceCreateRequest $request): ServiceCreateResponse {
    return new ServiceListResponse();
  }
}

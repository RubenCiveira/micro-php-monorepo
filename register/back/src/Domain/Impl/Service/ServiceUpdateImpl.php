<?php
namespace Register\Domain\Impl\Service;

use Register\Domain\Port\Api\Service\Update\ServiceUpdateUseCase;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateRequest;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceUpdateImpl implements ServiceUpdateUseCase {
  public function __construct(private readonly ServiceRepository $repository) {}
  public function Update(ServiceUpdateRequest $request): ServiceUpdateResponse {
    return new ServiceListResponse();
  }
}

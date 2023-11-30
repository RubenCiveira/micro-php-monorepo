<?php
namespace Register\Domain\Impl\Service;

use Register\Domain\Port\Api\Service\Delete\ServiceDeleteUseCase;
use Register\Domain\Port\Api\Service\Delete\ServiceDeleteRequest;
use Register\Domain\Port\Api\Service\Delete\ServiceDeleteResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceDeleteImpl implements ServiceDeleteUseCase {
  public function __construct(private readonly ServiceRepository $repository) {}
  public function Delete(ServiceDeleteRequest $request): ServiceDeleteResponse {
    $result = $this->repository->delete($request->ref);
    return new ServiceDeleteResponse(result: $result);
  }
}

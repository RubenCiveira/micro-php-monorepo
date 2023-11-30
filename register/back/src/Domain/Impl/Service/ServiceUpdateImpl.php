<?php
namespace Register\Domain\Impl\Service;

use Civi\Micro\Exception\OptimistLockException;

use Register\Domain\Port\Api\Service\Update\ServiceUpdateUseCase;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateRequest;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceUpdateImpl implements ServiceUpdateUseCase {
  public function __construct(private readonly ServiceRepository $repository) {}
  public function Update(ServiceUpdateRequest $request): ServiceUpdateResponse {
    if( $request->ref->uid !== $request->entity->uid) {
        throw new OptimistLockException($request->ref->uid, $request->entity->uid);
    }
    $updated = $this->repository->update($request->entity);
    return new ServiceUpdateResponse(data: $updated);
  }
}

<?php
namespace Register\Domain\Impl\Host;

use Civi\Micro\Exception\OptimistLockException;

use Register\Domain\Port\Api\Host\Update\HostUpdateUseCase;
use Register\Domain\Port\Api\Host\Update\HostUpdateRequest;
use Register\Domain\Port\Api\Host\Update\HostUpdateResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostUpdateImpl implements HostUpdateUseCase {
  public function __construct(private readonly HostRepository $repository) {}
  public function Update(HostUpdateRequest $request): HostUpdateResponse {
    if( $request->ref->uid !== $request->entity->uid) {
        throw new OptimistLockException($request->ref->uid, $request->entity->uid);
    }
    $updated = $this->repository->update($request->entity);
    return new HostUpdateResponse(data: $updated);
  }
}

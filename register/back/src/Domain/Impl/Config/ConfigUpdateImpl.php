<?php
namespace Register\Domain\Impl\Config;

use Civi\Micro\Exception\OptimistLockException;

use Register\Domain\Port\Api\Config\Update\ConfigUpdateUseCase;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateRequest;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateResponse;
use Register\Domain\Port\Spi\Config\ConfigRepository;

class ConfigUpdateImpl implements ConfigUpdateUseCase {
  public function __construct(private readonly ConfigRepository $repository) {}
  public function Update(ConfigUpdateRequest $request): ConfigUpdateResponse {
    if( $request->ref->uid !== $request->entity->uid) {
        throw new OptimistLockException($request->ref->uid, $request->entity->uid);
    }
    $updated = $this->repository->update($request->entity);
    return new ConfigUpdateResponse(data: $updated);
  }
}

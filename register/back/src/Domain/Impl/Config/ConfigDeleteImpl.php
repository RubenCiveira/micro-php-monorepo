<?php
namespace Register\Domain\Impl\Config;

use Register\Doamin\Port\Api\Config\Delete\ConfigDeleteUseCase;
use Register\Domain\Port\Api\Config\Delete\ConfigDeleteRequest;
use Register\Domain\Port\Api\Config\Delete\ConfigDeleteResponse;
use Register\Port\Spi\Config\ConfigRepository;

class ConfigDeleteImpl implements ConfigDeleteUseCase {
  public function __construct(private readonly ConfigRepository $repository) {}
  public function Delete(ConfigDeleteRequest $request): ConfigDeleteResponse {
    return new ConfigListResponse();
  }
}

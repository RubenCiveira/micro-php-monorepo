<?php
namespace Register\Domain\Impl\Config;

use Register\Doamin\Port\Api\Config\Update\ConfigUpdateUseCase;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateRequest;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateResponse;
use Register\Port\Spi\Config\ConfigRepository;

class ConfigUpdateImpl implements ConfigUpdateUseCase {
  public function __construct(private readonly ConfigRepository $repository) {}
  public function Update(ConfigUpdateRequest $request): ConfigUpdateResponse {
    return new ConfigListResponse();
  }
}

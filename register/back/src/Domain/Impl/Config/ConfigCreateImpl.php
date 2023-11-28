<?php
namespace Register\Domain\Impl\Config;

use Register\Doamin\Port\Api\Config\Create\ConfigCreateUseCase;
use Register\Domain\Port\Api\Config\Create\ConfigCreateRequest;
use Register\Domain\Port\Api\Config\Create\ConfigCreateResponse;
use Register\Port\Spi\Config\ConfigRepository;

class ConfigCreateImpl implements ConfigCreateUseCase {
  public function __construct(private readonly ConfigRepository $repository) {}
  public function Create(ConfigCreateRequest $request): ConfigCreateResponse {
    return new ConfigListResponse();
  }
}

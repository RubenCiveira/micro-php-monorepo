<?php
namespace Register\Domain\Impl\Config;

use Register\Doamin\Port\Api\Config\Retrieve\ConfigRetrieveUseCase;
use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveRequest;
use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveResponse;
use Register\Port\Spi\Config\ConfigRepository;

class ConfigRetrieveImpl implements ConfigRetrieveUseCase {
  public function __construct(private readonly ConfigRepository $repository) {}
  public function Retrieve(ConfigRetrieveRequest $request): ConfigRetrieveResponse {
    return new ConfigListResponse();
  }
}

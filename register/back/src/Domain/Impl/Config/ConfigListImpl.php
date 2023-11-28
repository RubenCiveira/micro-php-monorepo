<?php
namespace Register\Domain\Impl\Config;

use Register\Doamin\Port\Api\Config\List\ConfigListUseCase;
use Register\Domain\Port\Api\Config\List\ConfigListRequest;
use Register\Domain\Port\Api\Config\List\ConfigListResponse;
use Register\Port\Spi\Config\ConfigRepository;

class ConfigListImpl implements ConfigListUseCase {
  public function __construct(private readonly ConfigRepository $repository) {}
  public function List(ConfigListRequest $request): ConfigListResponse {
    return new ConfigListResponse();
  }
}

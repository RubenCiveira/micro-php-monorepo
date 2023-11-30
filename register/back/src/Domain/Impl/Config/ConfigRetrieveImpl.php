<?php
namespace Register\Domain\Impl\Config;


use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveUseCase;
use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveRequest;
use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveResponse;
use Register\Domain\Port\Spi\Config\ConfigRepository;

class ConfigRetrieveImpl implements ConfigRetrieveUseCase {
  public function __construct(private readonly ConfigRepository $repository) {}
  public function Retrieve(ConfigRetrieveRequest $request): ConfigRetrieveResponse {
    $finded = $this->repository->retrieve($request->ref);
    return new ConfigRetrieveResponse(data: $finded);
  }
}

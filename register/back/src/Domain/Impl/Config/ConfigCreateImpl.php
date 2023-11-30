<?php
namespace Register\Domain\Impl\Config;


use Register\Domain\Port\Api\Config\Create\ConfigCreateUseCase;
use Register\Domain\Port\Api\Config\Create\ConfigCreateRequest;
use Register\Domain\Port\Api\Config\Create\ConfigCreateResponse;
use Register\Domain\Port\Spi\Config\ConfigRepository;

class ConfigCreateImpl implements ConfigCreateUseCase {
  public function __construct(private readonly ConfigRepository $repository) {}
  public function Create(ConfigCreateRequest $request): ConfigCreateResponse {
    $created = $this->repository->create($request->entity);
    return new ConfigCreateResponse(data: $created);
  }
}

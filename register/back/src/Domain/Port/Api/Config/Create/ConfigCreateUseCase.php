<?php
namespace Register\Domain\Port\Api\Config\Create;


interface ConfigCreateUseCase {
  public function create(ConfigCreateRequest $request): ConfigCreateResponse;
}

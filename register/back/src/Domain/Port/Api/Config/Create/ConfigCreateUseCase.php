<?php
namespace Register\Domain\Port\Api\Config\Create;


interface ConfigCreateUseCase {
  public function Create(ConfigCreateRequest $request): ConfigCreateResponse;}

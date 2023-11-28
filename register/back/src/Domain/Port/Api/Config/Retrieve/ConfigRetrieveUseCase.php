<?php
namespace Register\Domain\Port\Api\Config\Retrieve;


interface ConfigRetrieveUseCase {
  public function Retrieve(ConfigRetrieveRequest $request): ConfigRetrieveResponse;}

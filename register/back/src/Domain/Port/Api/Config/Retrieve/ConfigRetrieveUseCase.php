<?php
namespace Register\Domain\Port\Api\Config\Retrieve;


interface ConfigRetrieveUseCase {
  public function retrieve(ConfigRetrieveRequest $request): ConfigRetrieveResponse;
}

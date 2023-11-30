<?php
namespace Register\Domain\Port\Api\Config\Update;


interface ConfigUpdateUseCase {
  public function update(ConfigUpdateRequest $request): ConfigUpdateResponse;
}

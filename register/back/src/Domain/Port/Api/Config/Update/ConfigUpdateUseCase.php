<?php
namespace Register\Domain\Port\Api\Config\Update;


interface ConfigUpdateUseCase {
  public function Update(ConfigUpdateRequest $request): ConfigUpdateResponse;
}

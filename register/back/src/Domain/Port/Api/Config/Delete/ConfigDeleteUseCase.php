<?php
namespace Register\Domain\Port\Api\Config\Delete;


interface ConfigDeleteUseCase {
  public function Delete(ConfigDeleteRequest $request): ConfigDeleteResponse;
}

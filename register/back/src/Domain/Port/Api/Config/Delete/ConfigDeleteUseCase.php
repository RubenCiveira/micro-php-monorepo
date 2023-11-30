<?php
namespace Register\Domain\Port\Api\Config\Delete;


interface ConfigDeleteUseCase {
  public function delete(ConfigDeleteRequest $request): ConfigDeleteResponse;
}

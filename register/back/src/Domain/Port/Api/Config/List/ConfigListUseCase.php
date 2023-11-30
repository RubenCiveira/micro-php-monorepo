<?php
namespace Register\Domain\Port\Api\Config\List;


interface ConfigListUseCase {
  public function list(ConfigListRequest $request): ConfigListResponse;
}

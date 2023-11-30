<?php
namespace Register\Domain\Port\Api\Config\List;


interface ConfigListUseCase {
  public function List(ConfigListRequest $request): ConfigListResponse;
}

<?php
namespace Register\Domain\Port\Api\Service\List;


interface ServiceListUseCase {
  public function list(ServiceListRequest $request): ServiceListResponse;
}

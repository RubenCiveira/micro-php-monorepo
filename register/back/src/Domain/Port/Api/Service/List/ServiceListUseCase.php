<?php
namespace Register\Domain\Port\Api\Service\List;


interface ServiceListUseCase {
  public function List(ServiceListRequest $request): ServiceListResponse;
}

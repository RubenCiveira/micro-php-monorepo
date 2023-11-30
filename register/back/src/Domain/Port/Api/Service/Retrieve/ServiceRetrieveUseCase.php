<?php
namespace Register\Domain\Port\Api\Service\Retrieve;


interface ServiceRetrieveUseCase {
  public function retrieve(ServiceRetrieveRequest $request): ServiceRetrieveResponse;
}

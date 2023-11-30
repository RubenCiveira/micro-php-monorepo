<?php
namespace Register\Domain\Port\Api\Service\Retrieve;


interface ServiceRetrieveUseCase {
  public function Retrieve(ServiceRetrieveRequest $request): ServiceRetrieveResponse;
}

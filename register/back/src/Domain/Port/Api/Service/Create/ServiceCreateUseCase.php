<?php
namespace Register\Domain\Port\Api\Service\Create;


interface ServiceCreateUseCase {
  public function create(ServiceCreateRequest $request): ServiceCreateResponse;
}

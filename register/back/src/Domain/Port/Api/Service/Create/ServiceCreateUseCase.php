<?php
namespace Register\Domain\Port\Api\Service\Create;


interface ServiceCreateUseCase {
  public function Create(ServiceCreateRequest $request): ServiceCreateResponse;
}

<?php
namespace Register\Domain\Port\Api\Service\Update;


interface ServiceUpdateUseCase {
  public function Update(ServiceUpdateRequest $request): ServiceUpdateResponse;}

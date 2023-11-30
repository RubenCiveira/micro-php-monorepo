<?php
namespace Register\Domain\Port\Api\Service\Update;


interface ServiceUpdateUseCase {
  public function update(ServiceUpdateRequest $request): ServiceUpdateResponse;
}

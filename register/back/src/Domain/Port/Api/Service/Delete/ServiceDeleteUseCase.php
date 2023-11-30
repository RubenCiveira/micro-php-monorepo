<?php
namespace Register\Domain\Port\Api\Service\Delete;


interface ServiceDeleteUseCase {
  public function Delete(ServiceDeleteRequest $request): ServiceDeleteResponse;
}

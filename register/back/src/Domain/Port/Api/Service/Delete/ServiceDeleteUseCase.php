<?php
namespace Register\Domain\Port\Api\Service\Delete;


interface ServiceDeleteUseCase {
  public function delete(ServiceDeleteRequest $request): ServiceDeleteResponse;
}

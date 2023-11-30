<?php
namespace Register\Domain\Port\Api\Host\Delete;


interface HostDeleteUseCase {
  public function Delete(HostDeleteRequest $request): HostDeleteResponse;
}

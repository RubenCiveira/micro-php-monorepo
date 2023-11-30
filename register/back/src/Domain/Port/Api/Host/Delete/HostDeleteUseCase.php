<?php
namespace Register\Domain\Port\Api\Host\Delete;


interface HostDeleteUseCase {
  public function delete(HostDeleteRequest $request): HostDeleteResponse;
}

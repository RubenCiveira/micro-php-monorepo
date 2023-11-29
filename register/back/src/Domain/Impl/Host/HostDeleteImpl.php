<?php
namespace Register\Domain\Impl\Host;

use Register\Domain\Port\Api\Host\Delete\HostDeleteUseCase;
use Register\Domain\Port\Api\Host\Delete\HostDeleteRequest;
use Register\Domain\Port\Api\Host\Delete\HostDeleteResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostDeleteImpl implements HostDeleteUseCase {
  public function __construct(private readonly HostRepository $repository) {}
  public function Delete(HostDeleteRequest $request): HostDeleteResponse {
    return new HostListResponse();
  }
}

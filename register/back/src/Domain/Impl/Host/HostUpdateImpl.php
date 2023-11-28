<?php
namespace Register\Domain\Impl\Host;

use Register\Doamin\Port\Api\Host\Update\HostUpdateUseCase;
use Register\Domain\Port\Api\Host\Update\HostUpdateRequest;
use Register\Domain\Port\Api\Host\Update\HostUpdateResponse;
use Register\Port\Spi\Host\HostRepository;

class HostUpdateImpl implements HostUpdateUseCase {
  public function __construct(private readonly HostRepository $repository) {}
  public function Update(HostUpdateRequest $request): HostUpdateResponse {
    return new HostListResponse();
  }
}

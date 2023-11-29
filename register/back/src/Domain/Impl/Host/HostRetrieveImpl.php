<?php
namespace Register\Domain\Impl\Host;

use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveUseCase;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveRequest;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostRetrieveImpl implements HostRetrieveUseCase {
  public function __construct(private readonly HostRepository $repository) {}
  public function Retrieve(HostRetrieveRequest $request): HostRetrieveResponse {
    return new HostListResponse();
  }
}

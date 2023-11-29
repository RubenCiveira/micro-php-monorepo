<?php
namespace Register\Domain\Impl\Host;

use Register\Domain\Port\Api\Host\Create\HostCreateUseCase;
use Register\Domain\Port\Api\Host\Create\HostCreateRequest;
use Register\Domain\Port\Api\Host\Create\HostCreateResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostCreateImpl implements HostCreateUseCase {
  public function __construct(private readonly HostRepository $repository) {}
  public function Create(HostCreateRequest $request): HostCreateResponse {
    return new HostListResponse();
  }
}

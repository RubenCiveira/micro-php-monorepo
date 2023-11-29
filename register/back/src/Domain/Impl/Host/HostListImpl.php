<?php
namespace Register\Domain\Impl\Host;

use Register\Domain\Port\Api\Host\List\HostListUseCase;
use Register\Domain\Port\Api\Host\List\HostListRequest;
use Register\Domain\Port\Api\Host\List\HostListResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostListImpl implements HostListUseCase {
  public function __construct(private readonly HostRepository $repository) {}
  public function List(HostListRequest $request): HostListResponse {
    return new HostListResponse(data: $this->repository->list($request->filter, $request->sort), next: null);
  }
}

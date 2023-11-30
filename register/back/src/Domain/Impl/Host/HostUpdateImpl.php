<?php
namespace Register\Domain\Impl\Host;

use Register\Domain\Port\Api\Host\Update\HostUpdateUseCase;
use Register\Domain\Port\Api\Host\Update\HostUpdateRequest;
use Register\Domain\Port\Api\Host\Update\HostUpdateResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostUpdateImpl implements HostUpdateUseCase {
  public function __construct(private readonly HostRepository $repository) {}
  public function Update(HostUpdateRequest $request): HostUpdateResponse {
    $updated = $this->repository->update($request->ref, $request->entity);
    return new HostUpdateResponse(data: $updated);
  }
}

<?php
namespace Register\Domain\Impl\Host;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\HostFilter;use Register\Domain\Impl\Service\ServiceVisibilityFilter;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Query\ServiceFilter;

use Register\Domain\Port\Api\Host\Delete\HostDeleteUseCase;
use Register\Domain\Port\Api\Host\Delete\HostDeleteRequest;
use Register\Domain\Port\Api\Host\Delete\HostDeleteResponse;
use Register\Domain\Port\Spi\Host\HostRepository;

class HostDeleteImpl implements HostDeleteUseCase {
  public function __construct(private readonly HostRepository $repository,
            private readonly ServiceVisibilityFilter $serviceVisibility,
            private readonly ServiceRepository $serviceRepository,
            private readonly HostVisibilityFilter $visibilityFilter) {}
  public function delete(HostDeleteRequest $request): HostDeleteResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, HostFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $result = $this->repository->delete($request->ref);
    return new HostDeleteResponse(result: $result);
  }
}

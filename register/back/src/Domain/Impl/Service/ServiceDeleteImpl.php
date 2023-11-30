<?php
namespace Register\Domain\Impl\Service;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\ServiceFilter;
use Register\Domain\Port\Api\Service\Delete\ServiceDeleteUseCase;
use Register\Domain\Port\Api\Service\Delete\ServiceDeleteRequest;
use Register\Domain\Port\Api\Service\Delete\ServiceDeleteResponse;
use Register\Domain\Port\Spi\Service\ServiceRepository;

class ServiceDeleteImpl implements ServiceDeleteUseCase {
  public function __construct(private readonly ServiceRepository $repository,
            private readonly ServiceVisibilityFilter $visibilityFilter) {}
  public function delete(ServiceDeleteRequest $request): ServiceDeleteResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, ServiceFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $result = $this->repository->delete($request->ref);
    return new ServiceDeleteResponse(result: $result);
  }
}

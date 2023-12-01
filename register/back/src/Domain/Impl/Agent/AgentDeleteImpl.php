<?php
namespace Register\Domain\Impl\Agent;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\AgentFilter;
use Register\Domain\Port\Api\Agent\Delete\AgentDeleteUseCase;
use Register\Domain\Port\Api\Agent\Delete\AgentDeleteRequest;
use Register\Domain\Port\Api\Agent\Delete\AgentDeleteResponse;
use Register\Domain\Port\Spi\Agent\AgentRepository;

class AgentDeleteImpl implements AgentDeleteUseCase {
  public function __construct(private readonly AgentRepository $repository,
            private readonly AgentVisibilityFilter $visibilityFilter) {}
  public function delete(AgentDeleteRequest $request): AgentDeleteResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, AgentFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $result = $this->repository->delete($request->ref);
    return new AgentDeleteResponse(result: $result);
  }
}

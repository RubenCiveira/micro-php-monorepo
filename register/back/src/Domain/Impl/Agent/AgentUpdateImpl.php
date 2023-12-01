<?php
namespace Register\Domain\Impl\Agent;

use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\AgentFilter;
use Register\Domain\Port\Api\Agent\Update\AgentUpdateUseCase;
use Register\Domain\Port\Api\Agent\Update\AgentUpdateRequest;
use Register\Domain\Port\Api\Agent\Update\AgentUpdateResponse;
use Register\Domain\Port\Spi\Agent\AgentRepository;

class AgentUpdateImpl implements AgentUpdateUseCase {
  public function __construct(private readonly AgentRepository $repository,
            private readonly AgentVisibilityFilter $visibilityFilter,
           private readonly AgentReadFilter $readFilter,
           private readonly AgentWriteFilter $writeFilter) {}
  public function update(AgentUpdateRequest $request): AgentUpdateResponse {
    $original = $this->repository->retrieve($request->ref, $this->visibilityFilter->buildFilter($request->actor, AgentFilter::builder()->build()) );
    if( !$original ) {
        throw new NotFoundException($request->ref->uid);
    }
    if( $request->ref->uid !== $request->entity->uid) {
        throw new OptimistLockException($request->ref->uid, $request->entity->uid);
    }
    $updated = $this->repository->update($this->writeFilter->transformFromInput($request->actor, $request->entity));
    return new AgentUpdateResponse(data: $this->readFilter->transformToOutput($request->actor, $updated) );
  }
}

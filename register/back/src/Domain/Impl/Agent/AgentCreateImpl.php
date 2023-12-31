<?php
namespace Register\Domain\Impl\Agent;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\AgentFilter;use Civi\Micro\Exception\OptimistLockException;
use Register\Domain\Impl\ExecutionGroup\ExecutionGroupVisibilityFilter;
use Register\Domain\Port\Spi\ExecutionGroup\ExecutionGroupRepository;
use Register\Domain\Model\Query\ExecutionGroupFilter;

use Register\Domain\Port\Api\Agent\Create\AgentCreateUseCase;
use Register\Domain\Port\Api\Agent\Create\AgentCreateRequest;
use Register\Domain\Port\Api\Agent\Create\AgentCreateResponse;
use Register\Domain\Port\Spi\Agent\AgentRepository;

class AgentCreateImpl implements AgentCreateUseCase {
  public function __construct(private readonly AgentRepository $repository,
            private readonly ExecutionGroupVisibilityFilter $executionGroupVisibility,
            private readonly ExecutionGroupRepository $executionGroupRepository,
            private readonly AgentVisibilityFilter $visibilityFilter,
           private readonly AgentReadFilter $readFilter,
           private readonly AgentWriteFilter $writeFilter) {}
  public function create(AgentCreateRequest $request): AgentCreateResponse {
    if( $request->entity->groups ) {
      foreach($request->entity->groups as $child) {
        if( !$child->agent || $child->agent->uid != $request->entity->uid) {
           throw new OptimistLockException($request->ref->uid, $request->entity->uid);
        }
        if( $child->group && !$this->executionGroupRepository->exists($child->group, $this->executionGroupVisibility->buildFilter($request->actor, ExecutionGroupFilter::builder()->build()) )  ) {
            throw new NotFoundException($child->group->uid);
        }
      }
    }
    $created = $this->repository->create($this->writeFilter->transformFromInput($request->actor, $request->entity) );
    if( !$this->repository->exists($created, $this->visibilityFilter->buildFilter($request->actor, AgentFilter::builder()->build()) ) ) {
        $this->repository->delete( $created );
        throw new NotFoundException($request->ref->uid);
    }
    return new AgentCreateResponse(data: $this->readFilter->transformToOutput($request->actor, $created) );
  }
}

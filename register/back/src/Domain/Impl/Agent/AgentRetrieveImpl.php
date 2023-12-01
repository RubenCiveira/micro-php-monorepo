<?php
namespace Register\Domain\Impl\Agent;

use Civi\Micro\Exception\NotFoundException;
use Register\Domain\Model\Query\AgentFilter;
use Register\Domain\Port\Api\Agent\Retrieve\AgentRetrieveUseCase;
use Register\Domain\Port\Api\Agent\Retrieve\AgentRetrieveRequest;
use Register\Domain\Port\Api\Agent\Retrieve\AgentRetrieveResponse;
use Register\Domain\Port\Spi\Agent\AgentRepository;

class AgentRetrieveImpl implements AgentRetrieveUseCase {
  public function __construct(private readonly AgentRepository $repository,
            private readonly AgentVisibilityFilter $visibilityFilter,
           private readonly AgentReadFilter $readFilter) {}
  public function retrieve(AgentRetrieveRequest $request): AgentRetrieveResponse {
    if( !$this->repository->exists( $request->ref, $this->visibilityFilter->buildFilter($request->actor, AgentFilter::builder()->build()) ) ) {
        throw new NotFoundException($request->ref->uid);
    }
    $finded = $this->repository->retrieve($request->ref);
    return new AgentRetrieveResponse(data: $this->readFilter->transformToOutput($request->actor, $finded) );
  }
}

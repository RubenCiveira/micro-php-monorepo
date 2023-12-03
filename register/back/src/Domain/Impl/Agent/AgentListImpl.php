<?php
namespace Register\Domain\Impl\Agent;

use Register\Domain\Impl\ExecutionGroup\ExecutionGroupVisibilityFilter;
use Register\Domain\Port\Spi\ExecutionGroup\ExecutionGroupRepository;
use Register\Domain\Model\Query\ExecutionGroupFilter;

use Register\Domain\Port\Api\Agent\List\AgentListUseCase;
use Register\Domain\Port\Api\Agent\List\AgentListRequest;
use Register\Domain\Port\Api\Agent\List\AgentListResponse;
use Register\Domain\Port\Spi\Agent\AgentRepository;

class AgentListImpl implements AgentListUseCase {
  public function __construct(private readonly AgentRepository $repository,
            private readonly ExecutionGroupVisibilityFilter $executionGroupVisibility,
            private readonly ExecutionGroupRepository $executionGroupRepository,
            private readonly AgentVisibilityFilter $visibilityFilter,
           private readonly AgentReadFilter $readFilter) {}
  public function list(AgentListRequest $request): AgentListResponse {
    $result = $this->repository->list( $this->visibilityFilter->buildFilter($request->actor, $request->filter), $request->sort);    return new AgentListResponse(data: $result->map( fn($row) => $this->readFilter->transformToOutput($request->actor, $row)), next: null);
  }
}

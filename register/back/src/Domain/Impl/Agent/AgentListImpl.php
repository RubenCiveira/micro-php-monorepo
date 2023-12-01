<?php
namespace Register\Domain\Impl\Agent;


use Register\Domain\Port\Api\Agent\List\AgentListUseCase;
use Register\Domain\Port\Api\Agent\List\AgentListRequest;
use Register\Domain\Port\Api\Agent\List\AgentListResponse;
use Register\Domain\Port\Spi\Agent\AgentRepository;

class AgentListImpl implements AgentListUseCase {
  public function __construct(private readonly AgentRepository $repository,
            private readonly AgentVisibilityFilter $visibilityFilter,
           private readonly AgentReadFilter $readFilter) {}
  public function list(AgentListRequest $request): AgentListResponse {
    $result = $this->repository->list( $this->visibilityFilter->buildFilter($request->actor, $request->filter), $request->sort);    return new AgentListResponse(data: array_map( fn($row) => $this->readFilter->transformToOutput($request->actor, $row), $result), next: null);
  }
}

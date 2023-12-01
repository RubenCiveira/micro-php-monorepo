<?php
namespace Register\Domain\Port\Api\Agent\List;


interface AgentListUseCase {
  public function list(AgentListRequest $request): AgentListResponse;
}

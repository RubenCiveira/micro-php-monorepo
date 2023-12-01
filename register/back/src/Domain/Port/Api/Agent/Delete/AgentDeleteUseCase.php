<?php
namespace Register\Domain\Port\Api\Agent\Delete;


interface AgentDeleteUseCase {
  public function delete(AgentDeleteRequest $request): AgentDeleteResponse;
}

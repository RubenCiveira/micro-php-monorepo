<?php
namespace Register\Domain\Port\Api\Agent\Update;


interface AgentUpdateUseCase {
  public function update(AgentUpdateRequest $request): AgentUpdateResponse;
}

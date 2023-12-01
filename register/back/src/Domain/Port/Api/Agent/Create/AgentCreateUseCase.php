<?php
namespace Register\Domain\Port\Api\Agent\Create;


interface AgentCreateUseCase {
  public function create(AgentCreateRequest $request): AgentCreateResponse;
}

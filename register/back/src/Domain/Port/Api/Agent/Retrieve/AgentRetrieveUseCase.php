<?php
namespace Register\Domain\Port\Api\Agent\Retrieve;


interface AgentRetrieveUseCase {
  public function retrieve(AgentRetrieveRequest $request): AgentRetrieveResponse;
}

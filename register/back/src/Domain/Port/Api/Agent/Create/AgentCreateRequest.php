<?php
namespace Register\Domain\Port\Api\Agent\Create;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Agent;

class AgentCreateRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly Agent $entity){}
}

<?php
namespace Register\Domain\Port\Api\Agent\Update;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\Agent;

class AgentUpdateRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly AgentRef $ref,
          public readonly Agent $entity){}
}

<?php
namespace Register\Domain\Port\Api\Agent\Delete;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\AgentRef;

class AgentDeleteRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly AgentRef $ref){}
}

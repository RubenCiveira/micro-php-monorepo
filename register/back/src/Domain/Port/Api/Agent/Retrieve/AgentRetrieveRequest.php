<?php
namespace Register\Domain\Port\Api\Agent\Retrieve;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\AgentRef;

class AgentRetrieveRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly AgentRef $ref){}
}

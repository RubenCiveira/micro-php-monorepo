<?php
namespace Register\Domain\Impl\Agent;

use Register\Domain\Model\Agent;
use Register\Domain\Model\Security\ActorRequest;

class AgentWriteFilter {
  public function transformFromInput(ActorRequest $actor, Agent $value): Agent {
    return $value;  }
}

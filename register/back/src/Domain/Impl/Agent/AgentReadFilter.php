<?php
namespace Register\Domain\Impl\Agent;

use Register\Domain\Model\Agent;
use Register\Domain\Model\Security\ActorRequest;

class AgentReadFilter {
  public function transformToOutput(ActorRequest $actor, Agent $value): Agent {
    return $value;
  }
}

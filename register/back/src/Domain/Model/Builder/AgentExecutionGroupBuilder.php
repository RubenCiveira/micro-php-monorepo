<?php
namespace Register\Domain\Model\Builder;

use Register\Domain\Model\AgentExecutionGroup;
use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\Ref\ExecutionGroupRef;

class AgentExecutionGroupBuilder {
  public function build(): AgentExecutionGroup{
    return new AgentExecutionGroup($this);
  }
  private int $uid;
  private AgentRef $agent;
  private ExecutionGroupRef $group;
  private ?int $version = null;
  public function getUid(): int {
    return $this->uid;
  }
  public function getAgent(): AgentRef {
    return $this->agent;
  }
  public function getGroup(): ExecutionGroupRef {
    return $this->group;
  }
  public function getVersion(): ?int {
    return $this->version;
  }
  public function uid(int $uid): AgentExecutionGroupBuilder {
    $this->uid = $uid;
    return $this;
  }
  public function agent(AgentRef $agent): AgentExecutionGroupBuilder {
    $this->agent = $agent;
    return $this;
  }
  public function group(ExecutionGroupRef $group): AgentExecutionGroupBuilder {
    $this->group = $group;
    return $this;
  }
  public function version(?int $version): AgentExecutionGroupBuilder {
    $this->version = $version;
    return $this;
  }
}

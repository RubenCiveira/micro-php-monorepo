<?php
namespace Register\Domain\Model\Builder;

use Register\Domain\Model\Agent;
use Register\Domain\Model\List\AgentExecutionGroupList;

class AgentBuilder {
  public function build(): Agent{
    return new Agent($this);
  }
  private int $uid;
  private string $name;
  private ?AgentExecutionGroupList $groups = null;
  private ?int $version = null;
  public function getUid(): int {
    return $this->uid;
  }
  public function getName(): string {
    return $this->name;
  }
  public function getGroups(): ?AgentExecutionGroupList {
    return $this->groups;
  }
  public function getVersion(): ?int {
    return $this->version;
  }
  public function uid(int $uid): AgentBuilder {
    $this->uid = $uid;
    return $this;
  }
  public function name(string $name): AgentBuilder {
    $this->name = $name;
    return $this;
  }
  public function groups(?AgentExecutionGroupList $groups): AgentBuilder {
    $this->groups = $groups;
    return $this;
  }
  public function version(?int $version): AgentBuilder {
    $this->version = $version;
    return $this;
  }
}

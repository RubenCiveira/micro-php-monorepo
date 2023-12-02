<?php
namespace Register\Domain\Model\Query;

use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\Ref\ExecutionGroupRef;

class AgentExecutionGroupFilterBuilder {
  public function build(): AgentExecutionGroupFilter {
    return new AgentExecutionGroupFilter($this);
  }
  private ?array $uids = null;
  private ?string $search = null;
  private ?AgentRef $agent = null;
  private ?ExecutionGroupRef $group = null;
  public function getUids(): ?array {
    return $this->uids;
  }
  public function getSearch(): ?string {
    return $this->search;
  }
  public function getAgent(): ?AgentRef {
    return $this->agent;
  }
  public function getGroup(): ?ExecutionGroupRef {
    return $this->group;
  }
  public function uids(array $uids): AgentExecutionGroupFilterBuilder {
    $this->uids = $uids;
    return $this;
  }
  public function search(string $search): AgentExecutionGroupFilterBuilder {
    $this->search = $search;
    return $this;
  }
  public function agent(?AgentRef $agent): AgentExecutionGroupFilterBuilder {
    $this->agent = $agent;
    return $this;
  }
  public function group(?ExecutionGroupRef $group): AgentExecutionGroupFilterBuilder {
    $this->group = $group;
    return $this;
  }
}

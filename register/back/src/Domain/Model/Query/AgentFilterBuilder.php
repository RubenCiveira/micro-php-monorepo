<?php
namespace Register\Domain\Model\Query;

class AgentFilterBuilder {
  public function build(): AgentFilter {
    return new AgentFilter($this);
  }
  private ?array $uids = null;
  private ?string $search = null;
  public function getUids(): ?array {
    return $this->uids;
  }
  public function getSearch(): ?string {
    return $this->search;
  }
  public function uids(array $uids): AgentFilterBuilder {
    $this->uids = $uids;
    return $this;
  }
  public function search(string $search): AgentFilterBuilder {
    $this->search = $search;
    return $this;
  }
}

<?php
namespace Register\Domain\Model\Query;

class ExecutionGroupFilterBuilder {
  public function build(): ExecutionGroupFilter {
    return new ExecutionGroupFilter($this);
  }
  private ?array $uids = null;
  private ?string $search = null;
  public function getUids(): ?array {
    return $this->uids;
  }
  public function getSearch(): ?string {
    return $this->search;
  }
  public function uids(array $uids): ExecutionGroupFilterBuilder {
    $this->uids = $uids;
    return $this;
  }
  public function search(string $search): ExecutionGroupFilterBuilder {
    $this->search = $search;
    return $this;
  }
}

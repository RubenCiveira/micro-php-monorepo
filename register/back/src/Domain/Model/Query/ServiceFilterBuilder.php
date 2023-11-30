<?php
namespace Register\Domain\Model\Query;

class ServiceFilterBuilder {
  public function build(): ServiceFilter {
    return new ServiceFilter($this);
  }
  private ?array $uids = null;
  private ?string $search = null;
  public function getUids(): ?array {
    return $this->uids;
  }
  public function getSearch(): ?string {
    return $this->search;
  }
  public function uids(array $uids): ServiceFilterBuilder {
    $this->uids = $uids;
    return $this;
  }
  public function search(string $search): ServiceFilterBuilder {
    $this->search = $search;
    return $this;
  }
}

<?php
namespace Register\Domain\Model\Query;

use Register\Domain\Model\Ref\ServiceRef;

class HostFilterBuilder {
  public function build(): HostFilter {
    return new HostFilter($this);
  }
  private ?array $uids = null;
  private ?string $search = null;
  private ?ServiceRef $service = null;
  public function getUids(): ?array {
    return $this->uids;
  }
  public function getSearch(): ?string {
    return $this->search;
  }
  public function getService(): ?ServiceRef {
    return $this->service;
  }
  public function uids(array $uids): HostFilterBuilder {
    $this->uids = $uids;
    return $this;
  }
  public function search(string $search): HostFilterBuilder {
    $this->search = $search;
    return $this;
  }
  public function service(?ServiceRef $service): HostFilterBuilder {
    $this->service = $service;
    return $this;
  }
}

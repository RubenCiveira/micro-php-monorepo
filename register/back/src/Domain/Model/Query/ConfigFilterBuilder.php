<?php
namespace Register\Domain\Model\Query;

use Register\Domain\Model\Ref\ServiceRef;

class ConfigFilterBuilder {
  public function build(): ConfigFilter {
    return new ConfigFilter($this);
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
  public function uids(array $uids): ConfigFilterBuilder {
    $this->uids = $uids;
    return $this;
  }
  public function search(string $search): ConfigFilterBuilder {
    $this->search = $search;
    return $this;
  }
  public function service(?ServiceRef $service): ConfigFilterBuilder {
    $this->service = $service;
    return $this;
  }
}

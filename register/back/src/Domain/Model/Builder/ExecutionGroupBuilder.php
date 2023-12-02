<?php
namespace Register\Domain\Model\Builder;

use Register\Domain\Model\ExecutionGroup;

class ExecutionGroupBuilder {
  public function build(): ExecutionGroup{
    return new ExecutionGroup($this);
  }
  private int $uid;
  private string $name;
  private ?int $version = null;
  public function getUid(): int {
    return $this->uid;
  }
  public function getName(): string {
    return $this->name;
  }
  public function getVersion(): ?int {
    return $this->version;
  }
  public function uid(int $uid): ExecutionGroupBuilder {
    $this->uid = $uid;
    return $this;
  }
  public function name(string $name): ExecutionGroupBuilder {
    $this->name = $name;
    return $this;
  }
  public function version(?int $version): ExecutionGroupBuilder {
    $this->version = $version;
    return $this;
  }
}

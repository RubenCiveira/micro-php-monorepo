<?php
namespace Register\Domain\Model\Builder;

use Register\Domain\Model\Service;

class ServiceBuilder {
  public function build(): Service{
    return new Service($this);
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
  public function uid(int $uid): ServiceBuilder {
    $this->uid = $uid;
    return $this;
  }
  public function name(string $name): ServiceBuilder {
    $this->name = $name;
    return $this;
  }
  public function version(?int $version): ServiceBuilder {
    $this->version = $version;
    return $this;
  }
}

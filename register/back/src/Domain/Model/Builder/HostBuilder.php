<?php
namespace Register\Domain\Model\Builder;

use Register\Domain\Model\Host;
use Register\Domain\Model\Ref\ServiceRef;

class HostBuilder {
  public function build(): Host{
    return new Host($this);
  }
  private int $uid;
  private string $name;
  private ServiceRef $service;
  private ?int $version;
  public function getUid(): int {
    return $this->uid;
  }
  public function getName(): string {
    return $this->name;
  }
  public function getService(): ServiceRef {
    return $this->service;
  }
  public function getVersion(): ?int {
    return $this->version;
  }
  public function uid(int $uid): HostBuilder {
    $this->uid = $uid;
    return $this;
  }
  public function name(string $name): HostBuilder {
    $this->name = $name;
    return $this;
  }
  public function service(ServiceRef $service): HostBuilder {
    $this->service = $service;
    return $this;
  }
  public function version(?int $version): HostBuilder {
    $this->version = $version;
    return $this;
  }
}

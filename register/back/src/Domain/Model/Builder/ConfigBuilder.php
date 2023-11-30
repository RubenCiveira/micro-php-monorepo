<?php
namespace Register\Domain\Model\Builder;

use Register\Domain\Model\Config;
use Register\Domain\Model\Ref\ServiceRef;

class ConfigBuilder {
  public function build(): Config{
    return new Config($this);
  }
  private int $uid;
  private ServiceRef $service;
  private string $property;
  private string $value;
  private ?int $version = null;
  public function getUid(): int {
    return $this->uid;
  }
  public function getService(): ServiceRef {
    return $this->service;
  }
  public function getProperty(): string {
    return $this->property;
  }
  public function getValue(): string {
    return $this->value;
  }
  public function getVersion(): ?int {
    return $this->version;
  }
  public function uid(int $uid): ConfigBuilder {
    $this->uid = $uid;
    return $this;
  }
  public function service(ServiceRef $service): ConfigBuilder {
    $this->service = $service;
    return $this;
  }
  public function property(string $property): ConfigBuilder {
    $this->property = $property;
    return $this;
  }
  public function value(string $value): ConfigBuilder {
    $this->value = $value;
    return $this;
  }
  public function version(?int $version): ConfigBuilder {
    $this->version = $version;
    return $this;
  }
}

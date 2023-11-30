<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\ConfigRef;
use Register\Domain\Model\Builder\ConfigBuilder;
use Register\Domain\Model\Ref\ServiceRef;

class Config extends ConfigRef {
  public static function builder() {
    return new ConfigBuilder();
  }
  public readonly ServiceRef $service;
  public readonly string $property;
  public readonly string $value;
  public readonly ?int $version;
  public function __construct(ConfigBuilder $builder) {
    parent::__construct($builder->getUid());
    $this->service = $builder->getService();
    $this->property = $builder->getProperty();
    $this->value = $builder->getValue();
    $this->version = $builder->getVersion();
  }
  public function toBuilder(): ConfigBuilder {
    $builder = new ConfigBuilder();
    $builder->uid( $this->uid);
    $builder->service( $this->service);
    $builder->property( $this->property);
    $builder->value( $this->value);
    $builder->version( $this->version);
    return $builder;
  }
}

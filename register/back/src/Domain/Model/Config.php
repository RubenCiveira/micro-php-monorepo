<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\ConfigRef;
use Register\Domain\Model\Builder\ConfigBuilder;
use Register\Domain\Model\Ref\ServiceRef;

class Config extends ConfigRef {
  public static function builder(): ConfigBuilder {
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
    if( $this->uid ) {
      $builder->uid( $this->uid);
    }
    if( $this->service ) {
      $builder->service( $this->service);
    }
    if( $this->property ) {
      $builder->property( $this->property);
    }
    if( $this->value ) {
      $builder->value( $this->value);
    }
    if( $this->version ) {
      $builder->version( $this->version);
    }
    return $builder;
  }
}

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
    if( isset($this->uid) ) {
      $builder->uid( $this->uid);
    }
    if( isset($this->service) ) {
      $builder->service( $this->service);
    }
    if( isset($this->property) ) {
      $builder->property( $this->property);
    }
    if( isset($this->value) ) {
      $builder->value( $this->value);
    }
    if( isset($this->version) ) {
      $builder->version( $this->version);
    }
    return $builder;
  }
}

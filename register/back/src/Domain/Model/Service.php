<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\ServiceRef;
use Register\Domain\Model\Builder\ServiceBuilder;

class Service extends ServiceRef {
  public static function builder(): ServiceBuilder {
    return new ServiceBuilder();
  }
  public readonly string $name;
  public readonly ?bool $enabled;
  public readonly ?int $version;
  public function __construct(ServiceBuilder $builder) {
    parent::__construct($builder->getUid());
    $this->name = $builder->getName();
    $this->enabled = $builder->getEnabled();
    $this->version = $builder->getVersion();
  }
  public function toBuilder(): ServiceBuilder {
    $builder = new ServiceBuilder();
    if( isset($this->uid) ) {
      $builder->uid( $this->uid);
    }
    if( isset($this->name) ) {
      $builder->name( $this->name);
    }
    if( isset($this->enabled) ) {
      $builder->enabled( $this->enabled);
    }
    if( isset($this->version) ) {
      $builder->version( $this->version);
    }
    return $builder;
  }
}

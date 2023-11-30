<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\ServiceRef;
use Register\Domain\Model\Builder\ServiceBuilder;

class Service extends ServiceRef {
  public static function builder() {
    return new ServiceBuilder();
  }
  public readonly string $name;
  public readonly ?int $version;
  public function __construct(ServiceBuilder $builder) {
    parent::__construct($builder->getUid());
    $this->name = $builder->getName();
    $this->version = $builder->getVersion();
  }
  public function toBuilder(): ServiceBuilder {
    $builder = new ServiceBuilder();
    $builder->uid( $this->uid);
    $builder->name( $this->name);
    $builder->version( $this->version);
    return $builder;
  }
}

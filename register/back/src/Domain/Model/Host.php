<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\HostRef;
use Register\Domain\Model\Builder\HostBuilder;
use Register\Domain\Model\Ref\ServiceRef;

class Host extends HostRef {
  public static function builder(): HostBuilder {
    return new HostBuilder();
  }
  public readonly string $name;
  public readonly ServiceRef $service;
  public readonly ?int $version;
  public function __construct(HostBuilder $builder) {
    parent::__construct($builder->getUid());
    $this->name = $builder->getName();
    $this->service = $builder->getService();
    $this->version = $builder->getVersion();
  }
  public function toBuilder(): HostBuilder {
    $builder = new HostBuilder();
    if( isset($this->uid) ) {
      $builder->uid( $this->uid);
    }
    if( isset($this->name) ) {
      $builder->name( $this->name);
    }
    if( isset($this->service) ) {
      $builder->service( $this->service);
    }
    if( isset($this->version) ) {
      $builder->version( $this->version);
    }
    return $builder;
  }
}

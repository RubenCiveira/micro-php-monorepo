<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\HostRef;
use Register\Domain\Model\Builder\HostBuilder;
use Register\Domain\Model\Ref\ServiceRef;

class Host extends HostRef {
  public static function builder() {
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
    $builder->uid( $this->uid);
    $builder->name( $this->name);
    $builder->service( $this->service);
    $builder->version( $this->version);
    return $builder;
  }
}

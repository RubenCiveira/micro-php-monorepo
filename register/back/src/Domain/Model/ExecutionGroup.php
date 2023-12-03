<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\ExecutionGroupRef;
use Register\Domain\Model\Builder\ExecutionGroupBuilder;

class ExecutionGroup extends ExecutionGroupRef {
  public static function builder(): ExecutionGroupBuilder {
    return new ExecutionGroupBuilder();
  }
  public readonly string $name;
  public readonly ?int $version;
  public function __construct(ExecutionGroupBuilder $builder) {
    parent::__construct($builder->getUid());
    $this->name = $builder->getName();
    $this->version = $builder->getVersion();
  }
  public function toBuilder(): ExecutionGroupBuilder {
    $builder = new ExecutionGroupBuilder();
    if( isset($this->uid) ) {
      $builder->uid( $this->uid);
    }
    if( isset($this->name) ) {
      $builder->name( $this->name);
    }
    if( isset($this->version) ) {
      $builder->version( $this->version);
    }
    return $builder;
  }
}

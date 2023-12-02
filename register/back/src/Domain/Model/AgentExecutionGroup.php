<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\AgentExecutionGroupRef;
use Register\Domain\Model\Builder\AgentExecutionGroupBuilder;
use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\Ref\ExecutionGroupRef;

class AgentExecutionGroup extends AgentExecutionGroupRef {
  public static function builder(): AgentExecutionGroupBuilder {
    return new AgentExecutionGroupBuilder();
  }
  public readonly AgentRef $agent;
  public readonly ExecutionGroupRef $group;
  public readonly ?int $version;
  public function __construct(AgentExecutionGroupBuilder $builder) {
    parent::__construct($builder->getUid());
    $this->agent = $builder->getAgent();
    $this->group = $builder->getGroup();
    $this->version = $builder->getVersion();
  }
  public function toBuilder(): AgentExecutionGroupBuilder {
    $builder = new AgentExecutionGroupBuilder();
    if( $this->uid ) {
      $builder->uid( $this->uid);
    }
    if( $this->agent ) {
      $builder->agent( $this->agent);
    }
    if( $this->group ) {
      $builder->group( $this->group);
    }
    if( $this->version ) {
      $builder->version( $this->version);
    }
    return $builder;
  }
}

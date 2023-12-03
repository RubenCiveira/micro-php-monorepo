<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\Builder\AgentBuilder;
use Register\Domain\Model\List\AgentExecutionGroupList;

class Agent extends AgentRef {
  public static function builder(): AgentBuilder {
    return new AgentBuilder();
  }
  public readonly string $name;
  public readonly ?AgentExecutionGroupList $groups;
  public readonly ?int $version;
  public function __construct(AgentBuilder $builder) {
    parent::__construct($builder->getUid());
    $this->name = $builder->getName();
    $this->groups = $builder->getGroups();
    $this->version = $builder->getVersion();
  }
  public function toBuilder(): AgentBuilder {
    $builder = new AgentBuilder();
    if( isset($this->uid) ) {
      $builder->uid( $this->uid);
    }
    if( isset($this->name) ) {
      $builder->name( $this->name);
    }
    if( isset($this->groups) ) {
      $builder->groups( $this->groups);
    }
    if( isset($this->version) ) {
      $builder->version( $this->version);
    }
    return $builder;
  }
}

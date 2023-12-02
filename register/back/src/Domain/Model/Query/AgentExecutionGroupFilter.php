<?php
namespace Register\Domain\Model\Query;

use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\Ref\ExecutionGroupRef;

class AgentExecutionGroupFilter {
  public static function builder(): AgentExecutionGroupFilterBuilder {
    return new AgentExecutionGroupFilterBuilder();
  }
    public readonly ?array $uids;
    public readonly ?string $search;
  public readonly ?AgentRef $agent;
  public readonly ?ExecutionGroupRef $group;
  public function __construct(AgentExecutionGroupFilterBuilder $builder) {
    $this->uids = $builder->getUids();
    $this->search = $builder->getSearch();
    $this->agent = $builder->getAgent();
    $this->group = $builder->getGroup();
  }
  public function toBuilder(): AgentExecutionGroupFilterBuilder {
    $builder = new AgentExecutionGroupFilterBuilder();
    if( $this->uids ) {
      $builder->uids( $this->uids );
    }
    if( $this->search ) {
      $builder->search( $this->search );
    }
    if( $this->agent ) {
      $builder->agent( $this->agent);
    }
    if( $this->group ) {
      $builder->group( $this->group);
    }
    return $builder;
  }
}

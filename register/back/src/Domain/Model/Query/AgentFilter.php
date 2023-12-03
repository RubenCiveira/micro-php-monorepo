<?php
namespace Register\Domain\Model\Query;

class AgentFilter {
  public static function builder(): AgentFilterBuilder {
    return new AgentFilterBuilder();
  }
    public readonly ?array $uids;
    public readonly ?string $search;
  public function __construct(AgentFilterBuilder $builder) {
    $this->uids = $builder->getUids();
    $this->search = $builder->getSearch();
  }
  public function toBuilder(): AgentFilterBuilder {
    $builder = new AgentFilterBuilder();
    if( isset($this->uids) ) {
      $builder->uids( $this->uids );
    }
    if( isset($this->search) ) {
      $builder->search( $this->search );
    }
    return $builder;
  }
}

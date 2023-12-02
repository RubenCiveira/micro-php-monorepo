<?php
namespace Register\Domain\Model\Query;

class ExecutionGroupFilter {
  public static function builder(): ExecutionGroupFilterBuilder {
    return new ExecutionGroupFilterBuilder();
  }
    public readonly ?array $uids;
    public readonly ?string $search;
  public function __construct(ExecutionGroupFilterBuilder $builder) {
    $this->uids = $builder->getUids();
    $this->search = $builder->getSearch();
  }
  public function toBuilder(): ExecutionGroupFilterBuilder {
    $builder = new ExecutionGroupFilterBuilder();
    if( $this->uids ) {
      $builder->uids( $this->uids );
    }
    if( $this->search ) {
      $builder->search( $this->search );
    }
    return $builder;
  }
}

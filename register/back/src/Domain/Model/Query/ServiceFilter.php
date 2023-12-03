<?php
namespace Register\Domain\Model\Query;

class ServiceFilter {
  public static function builder(): ServiceFilterBuilder {
    return new ServiceFilterBuilder();
  }
    public readonly ?array $uids;
    public readonly ?string $search;
  public function __construct(ServiceFilterBuilder $builder) {
    $this->uids = $builder->getUids();
    $this->search = $builder->getSearch();
  }
  public function toBuilder(): ServiceFilterBuilder {
    $builder = new ServiceFilterBuilder();
    if( isset($this->uids) ) {
      $builder->uids( $this->uids );
    }
    if( isset($this->search) ) {
      $builder->search( $this->search );
    }
    return $builder;
  }
}

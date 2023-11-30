<?php
namespace Register\Domain\Model\Query;

use Register\Domain\Model\Ref\ServiceRef;

class HostFilter {
  public static function builder(): HostFilterBuilder {
    return new HostFilterBuilder();
  }
    public readonly ?array $uids;
    public readonly ?string $search;
  public readonly ?ServiceRef $service;
  public function __construct(HostFilterBuilder $builder) {
    $this->uids = $builder->getUids();
    $this->search = $builder->getSearch();
    $this->service = $builder->getService();
  }
  public function toBuilder(): HostFilterBuilder {
    $builder = new HostFilterBuilder();
    if( $this->uids ) {
      $builder->uids( $this->uids );
    }
    if( $this->search ) {
      $builder->search( $this->search );
    }
    if( $this->service ) {
      $builder->service( $this->service);
    }
    return $builder;
  }
}

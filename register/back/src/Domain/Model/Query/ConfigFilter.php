<?php
namespace Register\Domain\Model\Query;

use Register\Domain\Model\Ref\ServiceRef;

class ConfigFilter {
  public static function builder(): ConfigFilterBuilder {
    return new ConfigFilterBuilder();
  }
    public readonly ?array $uids;
    public readonly ?string $search;
  public readonly ?ServiceRef $service;
  public function __construct(ConfigFilterBuilder $builder) {
    $this->uids = $builder->getUids();
    $this->search = $builder->getSearch();
    $this->service = $builder->getService();
  }
  public function toBuilder(): ConfigFilterBuilder {
    $builder = new ConfigFilterBuilder();
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

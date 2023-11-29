<?php
namespace Register\Domain\Port\Api\Service\List;

use Register\Domain\Model\Query\ServiceFilter;
use Register\Domain\Model\Query\ServiceSort;

class ServiceListRequest {
  public function __construct(public readonly ServiceFilter $filter,
          public readonly ServiceSort $sort){}
}

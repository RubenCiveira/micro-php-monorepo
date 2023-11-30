<?php
namespace Register\Domain\Port\Api\Config\List;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\ConfigFilter;
use Register\Domain\Model\Query\ConfigSort;

class ConfigListRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ConfigFilter $filter,
          public readonly ConfigSort $sort){}
}

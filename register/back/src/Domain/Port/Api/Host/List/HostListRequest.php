<?php
namespace Register\Domain\Port\Api\Host\List;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\HostFilter;
use Register\Domain\Model\Query\HostSort;

class HostListRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly HostFilter $filter,
          public readonly HostSort $sort){}
}

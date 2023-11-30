<?php
namespace Register\Domain\Impl\Host;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\HostFilter;

class HostVisibilityFilter {
  public function buildFilter(ActorRequest $actor, HostFilter $filter): HostFilter {
    return $filter;
  }
}

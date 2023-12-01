<?php
namespace Register\Domain\Impl\Service;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\ServiceFilter;

class ServiceVisibilityFilter {
  public function buildFilter(ActorRequest $actor, ServiceFilter $filter): ServiceFilter {
    return $filter;
  }
}

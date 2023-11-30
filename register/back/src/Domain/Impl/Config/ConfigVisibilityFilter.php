<?php
namespace Register\Domain\Impl\Config;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Query\ConfigFilter;

class ConfigVisibilityFilter {
  public function buildFilter(ActorRequest $actor, ConfigFilter $filter): ConfigFilter {
    return $filter;
  }
}

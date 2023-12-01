<?php
namespace Register\Domain\Impl\Service;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Service;

class ServicePropertyEnabledCalculator {
  public function calculateProperty(ActorRequest $actor, Service $from, ?Service $old = null): Service {
    return $from->toBuilder()->enabled(true)->build();
  }
}

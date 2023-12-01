<?php
namespace Register\Domain\Impl\Service;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Service;

class ServicePropertiesCalculator {
  public function __construct(  private readonly ServicePropertyEnabledCalculator $enabledCalculator) {}
  public function calculateProperties(ActorRequest $actor, Service $from, ?Service $old = null): Service {
    $from = $this->enabledCalculator->calculateProperty($actor, $from, $old);
    return $from;
  }
}

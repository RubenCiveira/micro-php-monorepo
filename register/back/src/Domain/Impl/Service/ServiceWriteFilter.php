<?php
namespace Register\Domain\Impl\Service;

use Register\Domain\Model\Service;
use Register\Domain\Model\Security\ActorRequest;

class ServiceWriteFilter {
  public function transformFromInput(ActorRequest $actor, Service $value): Service {
    return $value;  }
}

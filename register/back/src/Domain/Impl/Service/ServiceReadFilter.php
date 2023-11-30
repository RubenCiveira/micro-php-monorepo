<?php
namespace Register\Domain\Impl\Service;

use Register\Domain\Model\Service;
use Register\Domain\Model\Security\ActorRequest;

class ServiceReadFilter {
  public function transformToOutput(ActorRequest $actor, Service $value): Service {
    return $value;
  }
}

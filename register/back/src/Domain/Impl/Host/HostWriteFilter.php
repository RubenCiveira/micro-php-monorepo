<?php
namespace Register\Domain\Impl\Host;

use Register\Domain\Model\Host;
use Register\Domain\Model\Security\ActorRequest;

class HostWriteFilter {
  public function transformFromInput(ActorRequest $actor, Host $value): Host {
    return $value;  }
}

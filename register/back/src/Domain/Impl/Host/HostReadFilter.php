<?php
namespace Register\Domain\Impl\Host;

use Register\Domain\Model\Host;
use Register\Domain\Model\Security\ActorRequest;

class HostReadFilter {
  public function transformToOutput(ActorRequest $actor, Host $value): Host {
    return $value;
  }
}

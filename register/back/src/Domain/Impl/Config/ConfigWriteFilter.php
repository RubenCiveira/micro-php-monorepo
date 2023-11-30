<?php
namespace Register\Domain\Impl\Config;

use Register\Domain\Model\Config;
use Register\Domain\Model\Security\ActorRequest;

class ConfigWriteFilter {
  public function transformFromInput(ActorRequest $actor, Config $value): Config {
    return $value;  }
}

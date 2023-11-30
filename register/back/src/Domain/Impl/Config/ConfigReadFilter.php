<?php
namespace Register\Domain\Impl\Config;

use Register\Domain\Model\Config;
use Register\Domain\Model\Security\ActorRequest;

class ConfigReadFilter {
  public function transformToOutput(ActorRequest $actor, Config $value): Config {
    return $value;
  }
}

<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\ConfigRef;
use Register\Domain\Model\Ref\ServiceRef;

class Config extends ConfigRef {
  public function __construct(int $uid,
              public readonly ServiceRef $service,
              public readonly string $property,
              public readonly string $value,
              public readonly int $version) {
    parent::__construct( uid: $uid);
  }
}

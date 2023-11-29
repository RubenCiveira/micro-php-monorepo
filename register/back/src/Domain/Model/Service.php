<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\ServiceRef;

class Service extends ServiceRef {
  public function __construct(int $uid,
              public readonly string $name,
              public readonly int $version) {
    parent::__construct( uid: $uid);
  }
}

<?php
namespace Register\Domain\Model;

use Register\Domain\Model\Ref\HostRef;
use Register\Domain\Model\Ref\ServiceRef;

class Host extends HostRef {
  public function __construct(int $uid,
              public readonly string $name,
              public readonly ServiceRef $service,
              public readonly int $version) {
    parent::__construct( uid: $uid);
  }
}

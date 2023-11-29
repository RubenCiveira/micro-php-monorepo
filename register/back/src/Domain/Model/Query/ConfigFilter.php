<?php
namespace Register\Domain\Model\Query;

use Register\Domain\Model\Ref\ServiceRef;

class ConfigFilter {
  public function __construct(public readonly uids $uids,
              public readonly string $search,
              public readonly ServiceRef $service) {
  }
}

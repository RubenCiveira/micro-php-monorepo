<?php
namespace Register\Domain\Model\Query;

use Register\Domain\Model\Ref\ServiceRef;

class HostFilter {
  public function __construct(public readonly ?array $uids,
              public readonly ?string $search,
              public readonly ?ServiceRef $service) {
  }
}

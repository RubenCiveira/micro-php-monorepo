<?php
namespace Register\Domain\Model\Query;

class ServiceFilter {
  public function __construct(public readonly ?array $uids,
              public readonly ?string $search) {
  }
}

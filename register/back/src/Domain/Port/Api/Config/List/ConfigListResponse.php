<?php
namespace Register\Domain\Port\Api\Config\List;

use Register\Domain\Model\Config;

class ConfigListResponse {
  public function __construct(public readonly array $data,
          public readonly ?Config $next){}
}

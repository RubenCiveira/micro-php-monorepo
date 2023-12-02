<?php
namespace Register\Domain\Port\Api\Config\List;

use Register\Domain\Model\Config;
use Register\Domain\Model\List\ConfigList;

class ConfigListResponse {
  public function __construct(public readonly ConfigList $data,
          public readonly ?Config $next){}
}

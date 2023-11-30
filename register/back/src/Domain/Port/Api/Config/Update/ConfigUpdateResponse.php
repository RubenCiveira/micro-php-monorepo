<?php
namespace Register\Domain\Port\Api\Config\Update;

use Register\Domain\Model\Config;

class ConfigUpdateResponse {
  public function __construct(public readonly ?Config $data){}
}

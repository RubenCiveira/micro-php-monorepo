<?php
namespace Register\Domain\Port\Api\Config\Create;

use Register\Domain\Model\Config;

class ConfigCreateResponse {
  public function __construct(public readonly Config $data){}
}

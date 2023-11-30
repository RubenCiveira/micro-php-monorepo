<?php
namespace Register\Domain\Port\Api\Config\Retrieve;

use Register\Domain\Model\Config;

class ConfigRetrieveResponse {
  public function __construct(public readonly ?Config $data){}
}

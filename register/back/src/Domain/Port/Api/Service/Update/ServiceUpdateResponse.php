<?php
namespace Register\Domain\Port\Api\Service\Update;

use Register\Domain\Model\Service;

class ServiceUpdateResponse {
  public function __construct(public readonly ?Service $data){}
}

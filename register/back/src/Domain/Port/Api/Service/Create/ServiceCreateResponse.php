<?php
namespace Register\Domain\Port\Api\Service\Create;

use Register\Domain\Model\Service;

class ServiceCreateResponse {
  public function __construct(public readonly ?Service $data){}
}

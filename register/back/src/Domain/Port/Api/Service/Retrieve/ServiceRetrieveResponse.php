<?php
namespace Register\Domain\Port\Api\Service\Retrieve;

use Register\Domain\Model\Service;

class ServiceRetrieveResponse {
  public function __construct(public readonly ?Service $data){}
}

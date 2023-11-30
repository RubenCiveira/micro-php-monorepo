<?php
namespace Register\Domain\Port\Api\Service\Retrieve;

use Register\Domain\Model\Query\ServiceRef;

class ServiceRetrieveRequest {
  public function __construct(public readonly ?ServiceRef $ref){}
}

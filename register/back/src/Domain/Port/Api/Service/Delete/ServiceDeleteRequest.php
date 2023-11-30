<?php
namespace Register\Domain\Port\Api\Service\Delete;

use Register\Domain\Model\Query\ServiceRef;

class ServiceDeleteRequest {
  public function __construct(public readonly ?ServiceRef $ref){}
}

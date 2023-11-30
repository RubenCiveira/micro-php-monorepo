<?php
namespace Register\Domain\Port\Api\Service\Create;

use Register\Domain\Model\Service;

class ServiceCreateRequest {
  public function __construct(public readonly ?Service $entity){}
}

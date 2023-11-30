<?php
namespace Register\Domain\Port\Api\Service\Update;

use Register\Domain\Model\Ref\ServiceRef;
use Register\Domain\Model\Service;

class ServiceUpdateRequest {
  public function __construct(public readonly ServiceRef $ref,
          public readonly Service $entity){}
}

<?php
namespace Register\Domain\Port\Api\Service\ActionDisable;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ServiceRef;
use Register\Domain\Model\Service;

class ServiceActionDisableRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ServiceRef $ref){}
}

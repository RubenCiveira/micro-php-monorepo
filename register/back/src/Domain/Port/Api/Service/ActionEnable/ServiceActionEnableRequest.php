<?php
namespace Register\Domain\Port\Api\Service\ActionEnable;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ServiceRef;
use Register\Domain\Model\Service;

class ServiceActionEnableRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ServiceRef $ref){}
}

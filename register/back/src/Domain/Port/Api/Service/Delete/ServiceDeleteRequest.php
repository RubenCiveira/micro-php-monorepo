<?php
namespace Register\Domain\Port\Api\Service\Delete;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ServiceRef;

class ServiceDeleteRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ServiceRef $ref){}
}

<?php
namespace Register\Domain\Port\Api\Service\Retrieve;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\ServiceRef;

class ServiceRetrieveRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly ServiceRef $ref){}
}

<?php
namespace Register\Domain\Port\Api\Host\Retrieve;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\HostRef;

class HostRetrieveRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly HostRef $ref){}
}

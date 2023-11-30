<?php
namespace Register\Domain\Port\Api\Host\Update;

use Register\Domain\Model\Security\ActorRequest;
use Register\Domain\Model\Ref\HostRef;
use Register\Domain\Model\Host;

class HostUpdateRequest {
  public function __construct(public readonly ActorRequest $actor,
          public readonly HostRef $ref,
          public readonly Host $entity){}
}

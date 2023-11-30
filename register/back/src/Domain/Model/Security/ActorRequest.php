<?php
namespace Register\Domain\Model\Security;

class ActorRequest {
  public function __construct(public readonly bool $anonimous) {}
}

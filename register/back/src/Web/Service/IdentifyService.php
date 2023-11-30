<?php
namespace Register\Web\Service;

use Psr\Http\Message\RequestInterface;
use Register\Domain\Model\Security\ActorRequest;

class IdentifyService {
  public function identifyRequest(RequestInterface $request): ActorRequest {
    return new ActorRequest(anonimous: true);
  }
}

<?php
namespace Register\Web\Api\Host;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveUseCase;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveRequest;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveResponse;
use Register\Domain\Model\Ref\HostRef;

class HostRetrieveController {
  public function __construct(private readonly HostRetrieveUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function retrieve(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->retrieve( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): HostRetrieveRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    return new HostRetrieveRequest(actor: $actorRequest, ref: new HostRef(uid: $args['uid'] ));
  }
  private function toDto(HostRetrieveResponse $response) {
    return $response;
  }
}

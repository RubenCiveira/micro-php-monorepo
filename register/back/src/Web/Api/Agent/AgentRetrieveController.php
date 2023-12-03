<?php
namespace Register\Web\Api\Agent;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Agent\Retrieve\AgentRetrieveUseCase;
use Register\Domain\Port\Api\Agent\Retrieve\AgentRetrieveRequest;
use Register\Domain\Port\Api\Agent\Retrieve\AgentRetrieveResponse;
use Register\Domain\Model\Ref\AgentRef;

class AgentRetrieveController {
  public function __construct(private readonly AgentRetrieveUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function retrieve(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->retrieve( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): AgentRetrieveRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    return new AgentRetrieveRequest(actor: $actorRequest, ref: new AgentRef(uid: $args['uid'] ));
  }
  private function toDto(AgentRetrieveResponse $response) {
    return $response->data;
  }
}

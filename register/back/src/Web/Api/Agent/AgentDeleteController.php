<?php
namespace Register\Web\Api\Agent;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Agent\Delete\AgentDeleteUseCase;
use Register\Domain\Port\Api\Agent\Delete\AgentDeleteRequest;
use Register\Domain\Port\Api\Agent\Delete\AgentDeleteResponse;
use Register\Domain\Model\Ref\AgentRef;

class AgentDeleteController {
  public function __construct(private readonly AgentDeleteUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function delete(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->delete( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): AgentDeleteRequest {
    $actorRequest = $this->identity->identifyRequest($request);
  return new AgentDeleteRequest(actor: $actorRequest, ref: new AgentRef(uid: $args['uid']) );
  }
  private function toDto(AgentDeleteResponse $response) {
    return $response;
  }
}

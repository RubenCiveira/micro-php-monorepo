<?php
namespace Register\Web\Api\Agent;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Agent\Create\AgentCreateUseCase;
use Register\Domain\Port\Api\Agent\Create\AgentCreateRequest;
use Register\Domain\Port\Api\Agent\Create\AgentCreateResponse;
use Register\Domain\Model\Agent;

class AgentCreateController {
  public function __construct(private readonly AgentCreateUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): AgentCreateRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    $row = $request->getParsedBody();
    return new AgentCreateRequest(actor: $actorRequest, entity: Agent::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
             ->name( isset($row['name']) ? $row['name'] : null)
             ->version( isset($row['version']) ? $row['version'] : null)->build());
  }
  private function toDto(AgentCreateResponse $response) {
    return $response;
  }
}

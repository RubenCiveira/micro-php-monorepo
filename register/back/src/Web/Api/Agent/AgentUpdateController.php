<?php
namespace Register\Web\Api\Agent;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Agent\Update\AgentUpdateUseCase;
use Register\Domain\Port\Api\Agent\Update\AgentUpdateRequest;
use Register\Domain\Port\Api\Agent\Update\AgentUpdateResponse;
use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\Agent;

class AgentUpdateController {
  public function __construct(private readonly AgentUpdateUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function update(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->update( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): AgentUpdateRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    $row = $request->getParsedBody();
    return new AgentUpdateRequest(actor: $actorRequest, ref: new AgentRef(uid: $args['uid']), entity: Agent::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
             ->name( isset($row['name']) ? $row['name'] : null)
             ->version( isset($row['version']) ? $row['version'] : null)->build());
  }
  private function toDto(AgentUpdateResponse $response) {
    return $response;
  }
}

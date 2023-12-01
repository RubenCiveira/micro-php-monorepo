<?php
namespace Register\Web\Api\Agent;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Agent\List\AgentListUseCase;
use Register\Domain\Port\Api\Agent\List\AgentListRequest;
use Register\Domain\Port\Api\Agent\List\AgentListResponse;
use Register\Domain\Model\Query\AgentFilter;
use Register\Domain\Model\Query\AgentSort;

class AgentListController {
  public function __construct(private readonly AgentListUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function list(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->list( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): AgentListRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    return new AgentListRequest(actor: $actorRequest, filter: AgentFilter::builder()->build(), sort: new AgentSort());
  }
  private function toDto(AgentListResponse $response) {
    return $response;
  }
}

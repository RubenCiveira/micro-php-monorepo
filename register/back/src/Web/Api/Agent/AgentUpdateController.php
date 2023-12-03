<?php
namespace Register\Web\Api\Agent;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Agent\Update\AgentUpdateUseCase;
use Register\Domain\Port\Api\Agent\Update\AgentUpdateRequest;
use Register\Domain\Port\Api\Agent\Update\AgentUpdateResponse;
use Register\Domain\Model\Agent;
use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\List\AgentExecutionGroupList;
use Register\Domain\Model\AgentExecutionGroup;
use Register\Domain\Model\Ref\AgentExecutionGroupRef;
use Register\Domain\Model\Ref\ExecutionGroupRef;
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
    $groupsItems = [];
    if( isset($row['groups']) ) {
      foreach($row['groups'] as $item_row) {
        $child_entity = AgentExecutionGroup::builder()->uid( isset($item_row['uid']) ? $item_row['uid'] : null)
                     ->agent( new AgentRef( uid: $row['uid']))
                     ->group( isset($item_row['group']['uid']) ? new ExecutionGroupRef( uid : $item_row['group']['uid'] ) : null)
                     ->version( isset($item_row['version']) ? $item_row['version'] : 0)->build();
        $groupsItems[] = $child_entity;
      }
    }
    $entity = Agent::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
                 ->name( isset($row['name']) ? $row['name'] : null)
                 ->groups( new AgentExecutionGroupList( $groupsItems ))
                 ->version( isset($row['version']) ? $row['version'] : 0)->build();
    return new AgentUpdateRequest(actor: $actorRequest, ref: new AgentRef(uid: $args['uid']), entity: $entity);
  }
  private function toDto(AgentUpdateResponse $response) {
    return $response->data;
  }
}

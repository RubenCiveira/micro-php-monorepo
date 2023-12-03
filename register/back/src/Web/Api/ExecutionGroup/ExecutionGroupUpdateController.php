<?php
namespace Register\Web\Api\ExecutionGroup;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\ExecutionGroup\Update\ExecutionGroupUpdateUseCase;
use Register\Domain\Port\Api\ExecutionGroup\Update\ExecutionGroupUpdateRequest;
use Register\Domain\Port\Api\ExecutionGroup\Update\ExecutionGroupUpdateResponse;
use Register\Domain\Model\ExecutionGroup;
use Register\Domain\Model\Ref\ExecutionGroupRef;
class ExecutionGroupUpdateController {
  public function __construct(private readonly ExecutionGroupUpdateUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function update(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->update( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ExecutionGroupUpdateRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    $row = $request->getParsedBody();
    $entity = ExecutionGroup::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
                 ->name( isset($row['name']) ? $row['name'] : null)
                 ->version( isset($row['version']) ? $row['version'] : 0)->build();
    return new ExecutionGroupUpdateRequest(actor: $actorRequest, ref: new ExecutionGroupRef(uid: $args['uid']), entity: $entity);
  }
  private function toDto(ExecutionGroupUpdateResponse $response) {
    return $response->data;
  }
}

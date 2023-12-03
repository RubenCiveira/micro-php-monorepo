<?php
namespace Register\Web\Api\ExecutionGroup;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\ExecutionGroup\Create\ExecutionGroupCreateUseCase;
use Register\Domain\Port\Api\ExecutionGroup\Create\ExecutionGroupCreateRequest;
use Register\Domain\Port\Api\ExecutionGroup\Create\ExecutionGroupCreateResponse;
use Register\Domain\Model\ExecutionGroup;
use Register\Domain\Model\Ref\ExecutionGroupRef;
class ExecutionGroupCreateController {
  public function __construct(private readonly ExecutionGroupCreateUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ExecutionGroupCreateRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    $row = $request->getParsedBody();
    $entity = ExecutionGroup::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
                 ->name( isset($row['name']) ? $row['name'] : null)
                 ->version( isset($row['version']) ? $row['version'] : 0)->build();
    return new ExecutionGroupCreateRequest(actor: $actorRequest, entity: $entity);
  }
  private function toDto(ExecutionGroupCreateResponse $response) {
    return $response->data;
  }
}

<?php
namespace Register\Web\Api\ExecutionGroup;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\ExecutionGroup\Delete\ExecutionGroupDeleteUseCase;
use Register\Domain\Port\Api\ExecutionGroup\Delete\ExecutionGroupDeleteRequest;
use Register\Domain\Port\Api\ExecutionGroup\Delete\ExecutionGroupDeleteResponse;
use Register\Domain\Model\Ref\ExecutionGroupRef;

class ExecutionGroupDeleteController {
  public function __construct(private readonly ExecutionGroupDeleteUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function delete(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->delete( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ExecutionGroupDeleteRequest {
    $actorRequest = $this->identity->identifyRequest($request);
  return new ExecutionGroupDeleteRequest(actor: $actorRequest, ref: new ExecutionGroupRef(uid: $args['uid']) );
  }
  private function toDto(ExecutionGroupDeleteResponse $response) {
    return $response;
  }
}

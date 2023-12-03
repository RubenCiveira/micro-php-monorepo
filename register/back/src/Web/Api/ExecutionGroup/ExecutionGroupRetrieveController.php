<?php
namespace Register\Web\Api\ExecutionGroup;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\ExecutionGroup\Retrieve\ExecutionGroupRetrieveUseCase;
use Register\Domain\Port\Api\ExecutionGroup\Retrieve\ExecutionGroupRetrieveRequest;
use Register\Domain\Port\Api\ExecutionGroup\Retrieve\ExecutionGroupRetrieveResponse;
use Register\Domain\Model\Ref\ExecutionGroupRef;

class ExecutionGroupRetrieveController {
  public function __construct(private readonly ExecutionGroupRetrieveUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function retrieve(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->retrieve( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ExecutionGroupRetrieveRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    return new ExecutionGroupRetrieveRequest(actor: $actorRequest, ref: new ExecutionGroupRef(uid: $args['uid'] ));
  }
  private function toDto(ExecutionGroupRetrieveResponse $response) {
    return $response->data;
  }
}

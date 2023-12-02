<?php
namespace Register\Web\Api\ExecutionGroup;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\ExecutionGroup\List\ExecutionGroupListUseCase;
use Register\Domain\Port\Api\ExecutionGroup\List\ExecutionGroupListRequest;
use Register\Domain\Port\Api\ExecutionGroup\List\ExecutionGroupListResponse;
use Register\Domain\Model\Query\ExecutionGroupFilter;
use Register\Domain\Model\Query\ExecutionGroupSort;

class ExecutionGroupListController {
  public function __construct(private readonly ExecutionGroupListUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function list(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->list( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ExecutionGroupListRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    return new ExecutionGroupListRequest(actor: $actorRequest, filter: ExecutionGroupFilter::builder()->build(), sort: new ExecutionGroupSort());
  }
  private function toDto(ExecutionGroupListResponse $response) {
    return ['data' => $response->data->toArray(), 'next' => $response->next];
  }
}

<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Service\List\ServiceListUseCase;
use Register\Domain\Port\Api\Service\List\ServiceListRequest;
use Register\Domain\Port\Api\Service\List\ServiceListResponse;
use Register\Domain\Model\Query\ServiceFilter;
use Register\Domain\Model\Query\ServiceSort;

class ServiceListController {
  public function __construct(private readonly ServiceListUseCase $usecase) {}
  public function list(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->list( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceListRequest {
    return new ServiceListRequest(new ServiceFilter(uids: null,
              search: null), new ServiceSort());
  }
  private function toDto(ServiceListResponse $response) {
    return $response;
  }
}

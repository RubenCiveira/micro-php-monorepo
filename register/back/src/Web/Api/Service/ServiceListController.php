<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Service\List\ServiceListUseCase;
use Register\Domain\Port\Api\Service\List\ServiceListRequest;
use Register\Domain\Port\Api\Service\List\ServiceListResponse;

class ServiceListController {
  public function __construct(private readonly ServiceListUseCase $usecase) {}
  public function list(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->list( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceListRequest {
    $vo = new ServiceListRequest();
    return $vo;
  }
  private function toDto(ServiceListResponse $response) {
    return $response;
  }
}

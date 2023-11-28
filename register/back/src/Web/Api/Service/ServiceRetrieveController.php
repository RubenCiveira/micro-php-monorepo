<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveUseCase;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveRequest;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveResponse;

class ServiceRetrieveController {
  public function __construct(private readonly ServiceRetrieveUseCase $usecase) {}
  public function retrieve(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->retrieve( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceRetrieveRequest {
  $vo = new ServiceListRequest();
  return $vo;
  }
  private function toDto(ServiceRetrieveResponse $response) {
    return $response;
  }
}

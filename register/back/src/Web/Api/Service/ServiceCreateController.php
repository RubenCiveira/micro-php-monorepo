<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Service\Create\ServiceCreateUseCase;
use Register\Domain\Port\Api\Service\Create\ServiceCreateRequest;
use Register\Domain\Port\Api\Service\Create\ServiceCreateResponse;

class ServiceCreateController {
  public function __construct(private readonly ServiceCreateUseCase $usecase) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceCreateRequest {
  $vo = new ServiceListRequest();
  return $vo;
  }
  private function toDto(ServiceCreateResponse $response) {
    return $response;
  }
}

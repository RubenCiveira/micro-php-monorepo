<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateUseCase;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateRequest;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateResponse;

class ServiceUpdateController {
  public function __construct(private readonly ServiceUpdateUseCase $usecase) {}
  public function update(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->update( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceUpdateRequest {
  $vo = new ServiceListRequest();
  return $vo;
  }
  private function toDto(ServiceUpdateResponse $response) {
    return $response;
  }
}

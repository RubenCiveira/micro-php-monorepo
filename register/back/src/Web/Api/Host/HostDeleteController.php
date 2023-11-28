<?php
namespace Register\Web\Api\Host;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Host\Delete\HostDeleteUseCase;
use Register\Domain\Port\Api\Host\Delete\HostDeleteRequest;
use Register\Domain\Port\Api\Host\Delete\HostDeleteResponse;

class HostDeleteController {
  public function __construct(private readonly HostDeleteUseCase $usecase) {}
  public function delete(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->delete( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): HostDeleteRequest {
  $vo = new HostListRequest();
  return $vo;
  }
  private function toDto(HostDeleteResponse $response) {
    return $response;
  }
}

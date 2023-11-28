<?php
namespace Register\Web\Api\Host;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Host\List\HostListUseCase;
use Register\Domain\Port\Api\Host\List\HostListRequest;
use Register\Domain\Port\Api\Host\List\HostListResponse;

class HostListController {
  public function __construct(private readonly HostListUseCase $usecase) {}
  public function list(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->list( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): HostListRequest {
    $vo = new HostListRequest();
    return $vo;
  }
  private function toDto(HostListResponse $response) {
    return $response;
  }
}

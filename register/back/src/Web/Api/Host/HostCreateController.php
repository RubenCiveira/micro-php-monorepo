<?php
namespace Register\Web\Api\Host;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Host\Create\HostCreateUseCase;
use Register\Domain\Port\Api\Host\Create\HostCreateRequest;
use Register\Domain\Port\Api\Host\Create\HostCreateResponse;

class HostCreateController {
  public function __construct(private readonly HostCreateUseCase $usecase) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): HostCreateRequest {
  $vo = new HostListRequest();
  return $vo;
  }
  private function toDto(HostCreateResponse $response) {
    return $response;
  }
}

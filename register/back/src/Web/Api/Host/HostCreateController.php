<?php
namespace Register\Web\Api\Host;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Host\Create\HostCreateUseCase;
use Register\Domain\Port\Api\Host\Create\HostCreateRequest;
use Register\Domain\Port\Api\Host\Create\HostCreateResponse;
use Register\Domain\Model\Host;

class HostCreateController {
  public function __construct(private readonly HostCreateUseCase $usecase) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): HostCreateRequest {
    $row = $request->getParsedBody();
    return new HostCreateRequest(entity: Host::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
             ->name( isset($row['name']) ? $row['name'] : null)
             ->service( isset($row['service']) ? $row['service'] : null)
             ->version( isset($row['version']) ? $row['version'] : null)->build());
  }
  private function toDto(HostCreateResponse $response) {
    return $response;
  }
}

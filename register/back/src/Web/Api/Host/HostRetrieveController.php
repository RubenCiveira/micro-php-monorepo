<?php
namespace Register\Web\Api\Host;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveUseCase;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveRequest;
use Register\Domain\Port\Api\Host\Retrieve\HostRetrieveResponse;
use Register\Domain\Model\Ref\HostRef;

class HostRetrieveController {
  public function __construct(private readonly HostRetrieveUseCase $usecase) {}
  public function retrieve(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->retrieve( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): HostRetrieveRequest {
    return new HostRetrieveRequest(ref: new HostRef(uid: $args['uid'] ));
  }
  private function toDto(HostRetrieveResponse $response) {
    return $response;
  }
}

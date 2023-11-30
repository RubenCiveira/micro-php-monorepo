<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Service\Delete\ServiceDeleteUseCase;
use Register\Domain\Port\Api\Service\Delete\ServiceDeleteRequest;
use Register\Domain\Port\Api\Service\Delete\ServiceDeleteResponse;
use Register\Domain\Model\Ref\ServiceRef;

class ServiceDeleteController {
  public function __construct(private readonly ServiceDeleteUseCase $usecase) {}
  public function delete(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->delete( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceDeleteRequest {
  return new ServiceDeleteRequest(ref: new ServiceRef(uid: $args['uid']) );
  }
  private function toDto(ServiceDeleteResponse $response) {
    return $response;
  }
}

<?php
namespace Register\Web\Api\Config;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Config\Delete\ConfigDeleteUseCase;
use Register\Domain\Port\Api\Config\Delete\ConfigDeleteRequest;
use Register\Domain\Port\Api\Config\Delete\ConfigDeleteResponse;
use Register\Domain\Model\Ref\ConfigRef;

class ConfigDeleteController {
  public function __construct(private readonly ConfigDeleteUseCase $usecase) {}
  public function delete(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->delete( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ConfigDeleteRequest {
  return new ConfigDeleteRequest(ref: new ConfigRef(uid: $args['uid']) );
  }
  private function toDto(ConfigDeleteResponse $response) {
    return $response;
  }
}

<?php
namespace Register\Web\Api\Config;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveUseCase;
use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveRequest;
use Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveResponse;
use Register\Domain\Model\Ref\ConfigRef;

class ConfigRetrieveController {
  public function __construct(private readonly ConfigRetrieveUseCase $usecase) {}
  public function retrieve(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->retrieve( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ConfigRetrieveRequest {
    return new ConfigRetrieveRequest(ref: new ConfigRef(uid: $args['uid'] ));
  }
  private function toDto(ConfigRetrieveResponse $response) {
    return $response;
  }
}

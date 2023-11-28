<?php
namespace Register\Web\Api\Config;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Config\Create\ConfigCreateUseCase;
use Register\Domain\Port\Api\Config\Create\ConfigCreateRequest;
use Register\Domain\Port\Api\Config\Create\ConfigCreateResponse;

class ConfigCreateController {
  public function __construct(private readonly ConfigCreateUseCase $usecase) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ConfigCreateRequest {
  $vo = new ConfigListRequest();
  return $vo;
  }
  private function toDto(ConfigCreateResponse $response) {
    return $response;
  }
}

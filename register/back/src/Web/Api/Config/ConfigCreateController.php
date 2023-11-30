<?php
namespace Register\Web\Api\Config;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Config\Create\ConfigCreateUseCase;
use Register\Domain\Port\Api\Config\Create\ConfigCreateRequest;
use Register\Domain\Port\Api\Config\Create\ConfigCreateResponse;
use Register\Domain\Model\Config;

class ConfigCreateController {
  public function __construct(private readonly ConfigCreateUseCase $usecase) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ConfigCreateRequest {
    $row = $request->getParsedBody();
    return new ConfigCreateRequest(entity: Config::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
             ->service( isset($row['service']) ? $row['service'] : null)
             ->property( isset($row['property']) ? $row['property'] : null)
             ->value( isset($row['value']) ? $row['value'] : null)
             ->version( isset($row['version']) ? $row['version'] : null)->build());
  }
  private function toDto(ConfigCreateResponse $response) {
    return $response;
  }
}

<?php
namespace Register\Web\Api\Config;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateUseCase;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateRequest;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateResponse;
use Register\Domain\Model\Ref\ConfigRef;
use Register\Domain\Model\Config;

class ConfigUpdateController {
  public function __construct(private readonly ConfigUpdateUseCase $usecase) {}
  public function update(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->update( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ConfigUpdateRequest {
    $row = $request->getParsedBody();
    return new ConfigUpdateRequest(ref: new ConfigRef(uid: $args['uid']), entity: Config::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
             ->service( isset($row['service']) ? $row['service'] : null)
             ->property( isset($row['property']) ? $row['property'] : null)
             ->value( isset($row['value']) ? $row['value'] : null)
             ->version( isset($row['version']) ? $row['version'] : null)->build());
  }
  private function toDto(ConfigUpdateResponse $response) {
    return $response;
  }
}

<?php
namespace Register\Web\Api\Config;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateUseCase;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateRequest;
use Register\Domain\Port\Api\Config\Update\ConfigUpdateResponse;
use Register\Domain\Model\Config;
use Register\Domain\Model\Ref\ConfigRef;
use Register\Domain\Model\Ref\ServiceRef;
class ConfigUpdateController {
  public function __construct(private readonly ConfigUpdateUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function update(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->update( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ConfigUpdateRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    $row = $request->getParsedBody();
    $entity = Config::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
                 ->service( isset($row['service']['uid']) ? new ServiceRef( uid : $row['service']['uid'] ) : null)
                 ->property( isset($row['property']) ? $row['property'] : null)
                 ->value( isset($row['value']) ? $row['value'] : null)
                 ->version( isset($row['version']) ? $row['version'] : 0)->build();
    return new ConfigUpdateRequest(actor: $actorRequest, ref: new ConfigRef(uid: $args['uid']), entity: $entity);
  }
  private function toDto(ConfigUpdateResponse $response) {
    return $response->data;
  }
}

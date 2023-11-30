<?php
namespace Register\Web\Api\Config;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Config\Create\ConfigCreateUseCase;
use Register\Domain\Port\Api\Config\Create\ConfigCreateRequest;
use Register\Domain\Port\Api\Config\Create\ConfigCreateResponse;
use Register\Domain\Model\Config;
use Register\Domain\Model\Ref\ServiceRef;

class ConfigCreateController {
  public function __construct(private readonly ConfigCreateUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ConfigCreateRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    $row = $request->getParsedBody();
    return new ConfigCreateRequest(actor: $actorRequest, entity: Config::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
             ->service( isset($row['service']['uid']) ? new ServiceRef( uid : $row['service']['uid'] ) : null)
             ->property( isset($row['property']) ? $row['property'] : null)
             ->value( isset($row['value']) ? $row['value'] : null)
             ->version( isset($row['version']) ? $row['version'] : null)->build());
  }
  private function toDto(ConfigCreateResponse $response) {
    return $response;
  }
}

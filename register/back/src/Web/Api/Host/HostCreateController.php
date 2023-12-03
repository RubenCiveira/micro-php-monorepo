<?php
namespace Register\Web\Api\Host;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Host\Create\HostCreateUseCase;
use Register\Domain\Port\Api\Host\Create\HostCreateRequest;
use Register\Domain\Port\Api\Host\Create\HostCreateResponse;
use Register\Domain\Model\Host;
use Register\Domain\Model\Ref\HostRef;
use Register\Domain\Model\Ref\ServiceRef;
class HostCreateController {
  public function __construct(private readonly HostCreateUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): HostCreateRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    $row = $request->getParsedBody();
    $entity = Host::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
                 ->name( isset($row['name']) ? $row['name'] : null)
                 ->service( isset($row['service']['uid']) ? new ServiceRef( uid : $row['service']['uid'] ) : null)
                 ->version( isset($row['version']) ? $row['version'] : 0)->build();
    return new HostCreateRequest(actor: $actorRequest, entity: $entity);
  }
  private function toDto(HostCreateResponse $response) {
    return $response->data;
  }
}

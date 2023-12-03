<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Service\Create\ServiceCreateUseCase;
use Register\Domain\Port\Api\Service\Create\ServiceCreateRequest;
use Register\Domain\Port\Api\Service\Create\ServiceCreateResponse;
use Register\Domain\Model\Service;
use Register\Domain\Model\Ref\ServiceRef;
class ServiceCreateController {
  public function __construct(private readonly ServiceCreateUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function create(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->create( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceCreateRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    $row = $request->getParsedBody();
    $entity = Service::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
                 ->name( isset($row['name']) ? $row['name'] : null)
                 ->version( isset($row['version']) ? $row['version'] : 0)->build();
    return new ServiceCreateRequest(actor: $actorRequest, entity: $entity);
  }
  private function toDto(ServiceCreateResponse $response) {
    return $response->data;
  }
}

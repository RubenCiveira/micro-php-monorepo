<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveUseCase;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveRequest;
use Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveResponse;
use Register\Domain\Model\Ref\ServiceRef;

class ServiceRetrieveController {
  public function __construct(private readonly ServiceRetrieveUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function retrieve(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->retrieve( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceRetrieveRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    return new ServiceRetrieveRequest(actor: $actorRequest, ref: new ServiceRef(uid: $args['uid'] ));
  }
  private function toDto(ServiceRetrieveResponse $response) {
    return $response;
  }
}

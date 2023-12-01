<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Service\Enable\ServiceEnableUseCase;
use Register\Domain\Port\Api\Service\Enable\ServiceEnableRequest;
use Register\Domain\Port\Api\Service\Enable\ServiceEnableResponse;
use Register\Domain\Model\Ref\ServiceRef;

class ServiceEnableController {
  public function __construct(private readonly ServiceEnableUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function Enable(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->enable( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceEnableRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    return new ServiceEnableRequest(actor: $actorRequest, ref: new ServiceRef(uid: $args['uid']) );
  }
  private function toDto(ServiceEnableResponse $response) {
    return $response;
  }
}

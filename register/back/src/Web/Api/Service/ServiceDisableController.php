<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Service\Disable\ServiceDisableUseCase;
use Register\Domain\Port\Api\Service\Disable\ServiceDisableRequest;
use Register\Domain\Port\Api\Service\Disable\ServiceDisableResponse;
use Register\Domain\Model\Ref\ServiceRef;

class ServiceDisableController {
  public function __construct(private readonly ServiceDisableUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function Disable(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->disable( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceDisableRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    return new ServiceDisableRequest(actor: $actorRequest, ref: new ServiceRef(uid: $args['uid']) );
  }
  private function toDto(ServiceDisableResponse $response) {
    return $response;
  }
}

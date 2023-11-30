<?php
namespace Register\Web\Api\Service;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateUseCase;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateRequest;
use Register\Domain\Port\Api\Service\Update\ServiceUpdateResponse;
use Register\Domain\Model\Ref\ServiceRef;
use Register\Domain\Model\Service;

class ServiceUpdateController {
  public function __construct(private readonly ServiceUpdateUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function update(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->update( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ServiceUpdateRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    $row = $request->getParsedBody();
    return new ServiceUpdateRequest(actor: $actorRequest, ref: new ServiceRef(uid: $args['uid']), entity: Service::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
             ->name( isset($row['name']) ? $row['name'] : null)
             ->version( isset($row['version']) ? $row['version'] : null)->build());
  }
  private function toDto(ServiceUpdateResponse $response) {
    return $response;
  }
}

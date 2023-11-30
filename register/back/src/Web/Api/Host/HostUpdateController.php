<?php
namespace Register\Web\Api\Host;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Host\Update\HostUpdateUseCase;
use Register\Domain\Port\Api\Host\Update\HostUpdateRequest;
use Register\Domain\Port\Api\Host\Update\HostUpdateResponse;
use Register\Domain\Model\Ref\HostRef;
use Register\Domain\Model\Host;

class HostUpdateController {
  public function __construct(private readonly HostUpdateUseCase $usecase) {}
  public function update(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->update( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): HostUpdateRequest {
    $row = $request->getParsedBody();
    return new HostUpdateRequest(ref: new HostRef(uid: $args['uid']), entity: Host::builder()->uid( isset($row['uid']) ? $row['uid'] : null)
             ->name( isset($row['name']) ? $row['name'] : null)
             ->service( isset($row['service']) ? $row['service'] : null)
             ->version( isset($row['version']) ? $row['version'] : null)->build());
  }
  private function toDto(HostUpdateResponse $response) {
    return $response;
  }
}

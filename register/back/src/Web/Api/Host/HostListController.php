<?php
namespace Register\Web\Api\Host;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Web\Service\IdentifyService;
use Register\Domain\Port\Api\Host\List\HostListUseCase;
use Register\Domain\Port\Api\Host\List\HostListRequest;
use Register\Domain\Port\Api\Host\List\HostListResponse;
use Register\Domain\Model\Query\HostFilter;
use Register\Domain\Model\Query\HostSort;
use Register\Domain\Model\Ref\ServiceRef;

class HostListController {
  public function __construct(private readonly HostListUseCase $usecase,
                              private readonly IdentifyService $identity) {}
  public function list(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->list( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): HostListRequest {
    $actorRequest = $this->identity->identifyRequest($request);
    return new HostListRequest(actor: $actorRequest, filter: HostFilter::builder()->service( null )->build(), sort: new HostSort());
  }
  private function toDto(HostListResponse $response) {
    return $response;
  }
}

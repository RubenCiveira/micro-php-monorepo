<?php
namespace Register\Web\Api\Config;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Register\Domain\Port\Api\Config\List\ConfigListUseCase;
use Register\Domain\Port\Api\Config\List\ConfigListRequest;
use Register\Domain\Port\Api\Config\List\ConfigListResponse;
use Register\Domain\Model\Query\ConfigFilter;
use Register\Domain\Model\Query\ConfigSort;
use Register\Domain\Model\Ref\ServiceRef;

class ConfigListController {
  public function __construct(private readonly ConfigListUseCase $usecase) {}
  public function list(RequestInterface $request, ResponseInterface $response, $args) {
    $entity = $this->toRequest($request, $args);
    $dto = $this->toDto( $this->usecase->list( $entity ) );
    $response->getBody()->write( json_encode($dto) );
    return $response->withHeader('Content-Type', 'application/json');
  }
  private function toRequest(RequestInterface $request, $args): ConfigListRequest {
    return new ConfigListRequest(new ConfigFilter(uids: null,
              search: null,
              service: null), new ConfigSort());
  }
  private function toDto(ConfigListResponse $response) {
    return $response;
  }
}

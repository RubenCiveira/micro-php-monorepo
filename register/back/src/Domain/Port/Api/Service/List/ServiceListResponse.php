<?php
namespace Register\Domain\Port\Api\Service\List;

use Register\Domain\Model\Service;

class ServiceListResponse {
  public function __construct(public readonly array $data,
          public readonly ?Service $next){}
}

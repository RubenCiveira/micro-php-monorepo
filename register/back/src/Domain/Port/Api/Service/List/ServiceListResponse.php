<?php
namespace Register\Domain\Port\Api\Service\List;

use Register\Domain\Model\Service;
use Register\Domain\Model\List\ServiceList;

class ServiceListResponse {
  public function __construct(public readonly ServiceList $data,
          public readonly ?Service $next){}
}

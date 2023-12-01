<?php
namespace Register\Domain\Port\Api\Service\ActionDisable;

use Register\Domain\Model\Service;

class ServiceActionDisableResponse {
  public function __construct(public readonly ?Service $data){}
}

<?php
namespace Register\Domain\Port\Api\Service\ActionEnable;

use Register\Domain\Model\Service;

class ServiceActionEnableResponse {
  public function __construct(public readonly ?Service $data){}
}

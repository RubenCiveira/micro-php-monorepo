<?php
namespace Register\Domain\Port\Api\Host\Create;

use Register\Domain\Model\Host;

class HostCreateRequest {
  public function __construct(public readonly Host $entity){}
}

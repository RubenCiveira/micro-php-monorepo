<?php
namespace Register\Domain\Port\Api\Host\Delete;

use Register\Domain\Model\Query\HostRef;

class HostDeleteRequest {
  public function __construct(public readonly ?HostRef $ref){}
}

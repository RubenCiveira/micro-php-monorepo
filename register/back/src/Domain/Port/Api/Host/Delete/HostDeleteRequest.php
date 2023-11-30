<?php
namespace Register\Domain\Port\Api\Host\Delete;

use Register\Domain\Model\Ref\HostRef;

class HostDeleteRequest {
  public function __construct(public readonly HostRef $ref){}
}

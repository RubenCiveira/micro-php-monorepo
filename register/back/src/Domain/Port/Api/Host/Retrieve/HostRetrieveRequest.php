<?php
namespace Register\Domain\Port\Api\Host\Retrieve;

use Register\Domain\Model\Query\HostRef;

class HostRetrieveRequest {
  public function __construct(public readonly ?HostRef $ref){}
}

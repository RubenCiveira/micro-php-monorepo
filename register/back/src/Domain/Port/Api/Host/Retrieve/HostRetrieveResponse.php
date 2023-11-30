<?php
namespace Register\Domain\Port\Api\Host\Retrieve;

use Register\Domain\Model\Host;

class HostRetrieveResponse {
  public function __construct(public readonly Host $data){}
}

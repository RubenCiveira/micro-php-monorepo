<?php
namespace Register\Domain\Port\Api\Host\Update;

use Register\Domain\Model\Host;

class HostUpdateResponse {
  public function __construct(public readonly Host $data){}
}

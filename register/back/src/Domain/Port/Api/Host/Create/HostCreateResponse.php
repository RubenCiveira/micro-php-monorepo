<?php
namespace Register\Domain\Port\Api\Host\Create;

use Register\Domain\Model\Host;

class HostCreateResponse {
  public function __construct(public readonly ?Host $data){}
}

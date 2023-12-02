<?php
namespace Register\Domain\Port\Api\Host\List;

use Register\Domain\Model\Host;
use Register\Domain\Model\List\HostList;

class HostListResponse {
  public function __construct(public readonly HostList $data,
          public readonly ?Host $next){}
}

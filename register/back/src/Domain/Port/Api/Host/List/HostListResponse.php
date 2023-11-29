<?php
namespace Register\Domain\Port\Api\Host\List;

use Register\Domain\Model\Host;

class HostListResponse {
  public function __construct(public readonly array $data,
          public readonly ?Host $next){}
}

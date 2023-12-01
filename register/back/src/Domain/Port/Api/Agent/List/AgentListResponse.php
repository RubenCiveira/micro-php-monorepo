<?php
namespace Register\Domain\Port\Api\Agent\List;

use Register\Domain\Model\Agent;

class AgentListResponse {
  public function __construct(public readonly array $data,
          public readonly ?Agent $next){}
}

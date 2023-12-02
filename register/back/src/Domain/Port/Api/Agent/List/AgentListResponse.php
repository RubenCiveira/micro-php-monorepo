<?php
namespace Register\Domain\Port\Api\Agent\List;

use Register\Domain\Model\Agent;
use Register\Domain\Model\List\AgentList;

class AgentListResponse {
  public function __construct(public readonly AgentList $data,
          public readonly ?Agent $next){}
}

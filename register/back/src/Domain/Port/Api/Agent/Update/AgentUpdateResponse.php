<?php
namespace Register\Domain\Port\Api\Agent\Update;

use Register\Domain\Model\Agent;

class AgentUpdateResponse {
  public function __construct(public readonly ?Agent $data){}
}

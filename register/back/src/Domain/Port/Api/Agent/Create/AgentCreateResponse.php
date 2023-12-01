<?php
namespace Register\Domain\Port\Api\Agent\Create;

use Register\Domain\Model\Agent;

class AgentCreateResponse {
  public function __construct(public readonly ?Agent $data){}
}

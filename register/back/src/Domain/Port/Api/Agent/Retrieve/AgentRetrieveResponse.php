<?php
namespace Register\Domain\Port\Api\Agent\Retrieve;

use Register\Domain\Model\Agent;

class AgentRetrieveResponse {
  public function __construct(public readonly ?Agent $data){}
}

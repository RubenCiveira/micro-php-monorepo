<?php
namespace Register\Domain\Port\Api\Agent\Delete;


class AgentDeleteResponse {
  public function __construct(public readonly bool $result){}
}

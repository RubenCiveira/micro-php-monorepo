<?php
namespace Register\Domain\Port\Spi\Agent;

use Register\Domain\Model\Agent;
use Register\Domain\Model\List\AgentList;
use Register\Domain\Model\Query\AgentFilter;
use Register\Domain\Model\Query\AgentSort;
use Register\Domain\Model\Ref\AgentRef;

interface AgentRepository {
  public function create(Agent $entity): Agent;
  public function list(?AgentFilter $filter, ?AgentSort $sort): AgentList;
  public function retrieve(AgentRef $ref, ?AgentFilter $filter): ?Agent;
  public function update(Agent $entity): ?Agent;
  public function delete(AgentRef $ref): bool;
  public function exists(AgentRef $ref, ?AgentFilter $filter): bool;
}

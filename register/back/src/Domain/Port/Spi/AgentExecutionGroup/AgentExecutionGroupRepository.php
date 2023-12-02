<?php
namespace Register\Domain\Port\Spi\AgentExecutionGroup;

use Register\Domain\Model\AgentExecutionGroup;
use Register\Domain\Model\List\AgentExecutionGroupList;
use Register\Domain\Model\Query\AgentExecutionGroupFilter;
use Register\Domain\Model\Query\AgentExecutionGroupSort;
use Register\Domain\Model\Ref\AgentExecutionGroupRef;

interface AgentExecutionGroupRepository {
  public function create(AgentExecutionGroup $entity): AgentExecutionGroup;
  public function list(?AgentExecutionGroupFilter $filter, ?AgentExecutionGroupSort $sort): AgentExecutionGroupList;
  public function retrieve(AgentExecutionGroupRef $ref, ?AgentExecutionGroupFilter $filter): ?AgentExecutionGroup;
  public function update(AgentExecutionGroup $entity): ?AgentExecutionGroup;
  public function delete(AgentExecutionGroupRef $ref): bool;
  public function exists(AgentExecutionGroupRef $ref, ?AgentExecutionGroupFilter $filter): bool;
}

<?php
namespace Register\Domain\Port\Spi\ExecutionGroup;

use Register\Domain\Model\ExecutionGroup;
use Register\Domain\Model\Query\ExecutionGroupFilter;
use Register\Domain\Model\Query\ExecutionGroupSort;
use Register\Domain\Model\Ref\ExecutionGroupRef;

interface ExecutionGroupRepository {
  public function create(ExecutionGroup $entity): ExecutionGroup;
  public function list(?ExecutionGroupFilter $filter, ?ExecutionGroupSort $sort): array;
  public function retrieve(ExecutionGroupRef $ref, ?ExecutionGroupFilter $filter): ?ExecutionGroup;
  public function update(ExecutionGroup $entity): ?ExecutionGroup;
  public function delete(ExecutionGroupRef $ref): bool;
  public function exists(ExecutionGroupRef $ref, ?ExecutionGroupFilter $filter): bool;
}

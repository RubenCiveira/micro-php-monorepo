<?php
namespace Register\Domain\Port\Spi\Service;

use Register\Domain\Model\Service;
use Register\Domain\Model\Query\ServiceFilter;
use Register\Domain\Model\Query\ServiceSort;
use Register\Domain\Model\Ref\ServiceRef;

interface ServiceRepository {
  public function create(Service $entity): Service;
  public function list(?ServiceFilter $filter, ?ServiceSort $sort): array;
  public function retrieve(ServiceRef $ref, ?ServiceFilter $filter): ?Service;
  public function update(Service $entity): ?Service;
  public function delete(ServiceRef $ref): bool;
  public function exists(ServiceRef $ref, ?ServiceFilter $filter): bool;
}

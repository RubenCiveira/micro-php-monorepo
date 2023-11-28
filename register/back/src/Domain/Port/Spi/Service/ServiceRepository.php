<?php
namespace Register\Domain\Port\Spi\Service;

use Register\Domain\Model\Service;use Register\Domain\Model\ServiceFilter;
interface ServiceRepository {
  public function create(Service $entity): Service;
  public function list(ServiceFilter $filter): array;
  public function retrieve(ServiceRef $filter): Service;
  public function update(Service $entity): Service;
  public function delete(ServiceRef $entity);
  public function exists(ServiceRef $entity, ServiceFilter $filter): boolean;
}

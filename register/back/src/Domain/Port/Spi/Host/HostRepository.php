<?php
namespace Register\Domain\Port\Spi\Host;

use Register\Domain\Model\Host;use Register\Domain\Model\HostFilter;
interface HostRepository {
  public function create(Host $entity): Host;
  public function list(HostFilter $filter): array;
  public function retrieve(HostRef $filter): Host;
  public function update(Host $entity): Host;
  public function delete(HostRef $entity);
  public function exists(HostRef $entity, HostFilter $filter): boolean;
}

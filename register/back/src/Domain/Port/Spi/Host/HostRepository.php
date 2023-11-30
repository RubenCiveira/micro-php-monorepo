<?php
namespace Register\Domain\Port\Spi\Host;

use Register\Domain\Model\Host;
use Register\Domain\Model\Query\HostFilter;
use Register\Domain\Model\Query\HostSort;
use Register\Domain\Model\Ref\HostRef;

interface HostRepository {
  public function create(Host $entity): Host;
  public function list(?HostFilter $filter, ?HostSort $sort): array;
  public function retrieve(HostRef $filter): ?Host;
  public function update(Host $entity): ?Host;
  public function delete(HostRef $entity): bool;
  public function exists(HostRef $entity, ?HostFilter $filter): bool;
}

<?php
namespace Register\Domain\Port\Spi\Config;

use Register\Domain\Model\Config;
use Register\Domain\Model\Query\ConfigFilter;
use Register\Domain\Model\Query\ConfigSort;
use Register\Domain\Model\Ref\ConfigRef;

interface ConfigRepository {
  public function create(Config $entity): Config;
  public function list(?ConfigFilter $filter, ?ConfigSort $sort): array;
  public function retrieve(ConfigRef $filter): ?Config;
  public function update(Config $entity): ?Config;
  public function delete(ConfigRef $entity): bool;
  public function exists(ConfigRef $entity, ?ConfigFilter $filter): bool;
}

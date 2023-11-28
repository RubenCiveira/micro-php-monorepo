<?php
namespace Register\Domain\Port\Spi\Config;

use Register\Domain\Model\Config;use Register\Domain\Model\ConfigFilter;
interface ConfigRepository {
  public function create(Config $entity): Config;
  public function list(ConfigFilter $filter): array;
  public function retrieve(ConfigRef $filter): Config;
  public function update(Config $entity): Config;
  public function delete(ConfigRef $entity);
  public function exists(ConfigRef $entity, ConfigFilter $filter): boolean;
}

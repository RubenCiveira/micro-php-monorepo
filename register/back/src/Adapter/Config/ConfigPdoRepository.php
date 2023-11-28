<?php
namespace Register\Adapter\Config;

use Register\Port\Spi\Config\ConfigRepository;

class ConfigPdoRepository implements ConfigRepository {
  public function __construct(private readonly PDO $db) {}
  public function list(ConfigFilter $filter): array {
  }
  public function create(Config $entity): Config {
  }
  public function retrieve(ConfigRef $entity): Config {
  }
  public function update(Config $update): Config {
  }
  public function delete(ConfigRef $entity) {
  }
  public function exists(ConfigRef $entity, ConfigFilter $filter): Config {
  }
}

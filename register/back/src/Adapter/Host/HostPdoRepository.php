<?php
namespace Register\Adapter\Host;

use Register\Port\Spi\Host\HostRepository;

class HostPdoRepository implements HostRepository {
  public function __construct(private readonly PDO $db) {}
  public function list(HostFilter $filter): array {
  }
  public function create(Host $entity): Host {
  }
  public function retrieve(HostRef $entity): Host {
  }
  public function update(Host $update): Host {
  }
  public function delete(HostRef $entity) {
  }
  public function exists(HostRef $entity, HostFilter $filter): Host {
  }
}

<?php
namespace Register\Adapter\Service;

use Register\Port\Spi\Service\ServiceRepository;

class ServicePdoRepository implements ServiceRepository {
  public function __construct(private readonly PDO $db) {}
  public function list(ServiceFilter $filter): array {
  }
  public function create(Service $entity): Service {
  }
  public function retrieve(ServiceRef $entity): Service {
  }
  public function update(Service $update): Service {
  }
  public function delete(ServiceRef $entity) {
  }
  public function exists(ServiceRef $entity, ServiceFilter $filter): Service {
  }
}

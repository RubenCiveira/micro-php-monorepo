<?php
namespace Register\Adapter\Config;

use Closure;
use Civi\Micro\Sql\SqlTemplate;
use Register\Domain\Port\Spi\Config\ConfigRepository;
use Register\Domain\Model\Config;
use Register\Domain\Model\Query\ConfigFilter;
use Register\Domain\Model\Query\ConfigSort;
use Register\Domain\Model\Ref\ConfigRef;
use Civi\Micro\Sql\NotUniqueException;
use Civi\Micro\Exception\ConstraintException;
use Register\Domain\Model\Ref\ServiceRef;


class ConfigSqlRepository implements ConfigRepository {
  public function __construct(private readonly SqlTemplate $db) {}
  public function list(?ConfigFilter $filter, ?ConfigSort $sort): array {
    $sqlFilter = $this->filter(null, $filter, $sort);
    return $this->db->query($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row) );
  }
  public function create(Config $entity): Config {
    $entity->setVersion(0);
    try {
      $this->db->execute('INSERT INTO config ( uid, service, property, value, version) VALUES ( :uid, :service, :property, :value, :version)',[
           'uid' => $entity->uid,
           'service' => $entity->service?->uid,
           'property' => $entity->property,
           'value' => $entity->value,
           'version' => $entity->version
      ]);
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $entity;
  }
  public function retrieve(ConfigRef $entity): ?Config {
    return $this->db->findOne('SELECT uid FROM config where uid = :uid',['uid' => $entity->uid], fn($row) => this->mapper($row));
  }
  public function update(Config $update): ?Config {
    $version = $update->version;
    $update->Version(0);
    try {
      $result = $this->db->execute('UPDATE config SET service = :service and property = :property and value = :value and version = :version WHERE uid = :uid and version = :version', [
           'uid' => $update->uid,
           'service' => $update->service?->uid,
           'property' => $update->property,
           'value' => $update->value,
           'version' => $update->version
      ]);
      if( !$result && $this->db->exists('select uid from config where uid = :uid', ['uid' => $update->uid ]) ) {
        throw new Error('Precondition fail ' . $this->uid);
      } else if(!$result) {
        throw new Error('Not found ' . $this->uid);
      }
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $update;
  }
  public function delete(ConfigRef $entity): bool {
    return $this->db->execute('DELETE FROM config where uid = :uid',['uid' => $entity->uid]);
  }
  public function exists(ConfigRef $entity, ?ConfigFilter $filter): bool {
    $sqlFilter = $this->filter($entity, $filter, null);
    return $this->db->exists($sqlFilter['query'], $sqlFilter['params']);
  }
  private function filter(?ConfigRef $ref,?ConfigFilter $filter,?ConfigSort $sort) {
    $join = '';
    $query = '';
    $params = [];
    if( $ref && $ref->uid ) {
      $query .= ' and uid = :uid';
      $params['uid'] = $ref->uid;
    }
    if( $filter ) {
      if( $filter->service) {
        $query .= ' and service = :service';
        $params['service'] = $filter->service;
      }
    }
    return ['query' => 'SELECT * FROM config'
                          . ($join ? ' JOIN ' . substr($join, 6) : '')
                          . ($query ? ' WHERE ' . substr($query, 4) : ''),
                 'params' => $params];
  }
  private function checkDuplicates(Config $entity) {
    $values = ['uid' => $entity->uid];
    if( $this->pdo->exists('SELECT  uid from config where uid = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
  }
  private function mapper($row): Config{
    return new Config(uid: $row['uid'],
          service: new ServiceRef(uid: $row['service']),
          property: $row['property'],
          value: $row['value'],
          version: $row['version']);
  }
}


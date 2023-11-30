<?php
namespace Register\Adapter\Host;

use Closure;
use Civi\Micro\Sql\SqlTemplate;
use Register\Domain\Port\Spi\Host\HostRepository;
use Register\Domain\Model\Host;
use Register\Domain\Model\Query\HostFilter;
use Register\Domain\Model\Query\HostSort;
use Register\Domain\Model\Ref\HostRef;
use Civi\Micro\Sql\NotUniqueException;
use Civi\Micro\Exception\ConstraintException;
use Register\Domain\Model\Ref\ServiceRef;


class HostSqlRepository implements HostRepository {
  public function __construct(private readonly SqlTemplate $db) {}
  public function list(?HostFilter $filter, ?HostSort $sort): array {
    $sqlFilter = $this->filter(null, $filter, $sort);
    return $this->db->query($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row) );
  }
  public function create(Host $entity): Host {
    $entity->setVersion(0);
    try {
      $this->db->execute('INSERT INTO host ( uid, name, service, version) VALUES ( :uid, :name, :service, :version)',[
           'uid' => $entity->uid,
           'name' => $entity->name,
           'service' => $entity->service?->uid,
           'version' => $entity->version
      ]);
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $entity;
  }
  public function retrieve(HostRef $entity): ?Host {
    return $this->db->findOne('SELECT uid FROM host where uid = :uid',['uid' => $entity->uid], fn($row) => this->mapper($row));
  }
  public function update(Host $update): ?Host {
    $version = $update->version;
    $update->Version(0);
    try {
      $result = $this->db->execute('UPDATE host SET name = :name and service = :service and version = :version WHERE uid = :uid and version = :version', [
           'uid' => $update->uid,
           'name' => $update->name,
           'service' => $update->service?->uid,
           'version' => $update->version
      ]);
      if( !$result && $this->db->exists('select uid from host where uid = :uid', ['uid' => $update->uid ]) ) {
        throw new Error('Precondition fail ' . $this->uid);
      } else if(!$result) {
        throw new Error('Not found ' . $this->uid);
      }
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $update;
  }
  public function delete(HostRef $entity): bool {
    return $this->db->execute('DELETE FROM host where uid = :uid',['uid' => $entity->uid]);
  }
  public function exists(HostRef $entity, ?HostFilter $filter): bool {
    $sqlFilter = $this->filter($entity, $filter, null);
    return $this->db->exists($sqlFilter['query'], $sqlFilter['params']);
  }
  private function filter(?HostRef $ref,?HostFilter $filter,?HostSort $sort) {
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
    return ['query' => 'SELECT * FROM host'
                          . ($join ? ' JOIN ' . substr($join, 6) : '')
                          . ($query ? ' WHERE ' . substr($query, 4) : ''),
                 'params' => $params];
  }
  private function checkDuplicates(Host $entity) {
    $values = ['uid' => $entity->uid];
    if( $this->pdo->exists('SELECT  uid from host where uid = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
    $values = ['name' => $entity->name];
    if( $this->pdo->exists('SELECT  name from host where name = :name and uid != :uid', $values) ) {
      throw new ConstraintException('not-unique', ['name' => $entity->name]);
    }
  }
  private function mapper($row): Host{
    return new Host(uid: $row['uid'],
          name: $row['name'],
          service: new ServiceRef(uid: $row['service']),
          version: $row['version']);
  }
}


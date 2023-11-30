<?php
namespace Register\Adapter\Service;

use Closure;
use Civi\Micro\Sql\SqlTemplate;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Service;
use Register\Domain\Model\Query\ServiceFilter;
use Register\Domain\Model\Query\ServiceSort;
use Register\Domain\Model\Ref\ServiceRef;
use Civi\Micro\Sql\NotUniqueException;
use Civi\Micro\Exception\ConstraintException;


class ServiceSqlRepository implements ServiceRepository {
  public function __construct(private readonly SqlTemplate $db) {}
  public function list(?ServiceFilter $filter, ?ServiceSort $sort): array {
    $sqlFilter = $this->filter(null, $filter, $sort);
    return $this->db->query($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row) );
  }
  public function create(Service $entity): Service {
    $entity->setVersion(0);
    try {
      $this->db->execute('INSERT INTO service ( uid, name, version) VALUES ( :uid, :name, :version)',[
           'uid' => $entity->uid,
           'name' => $entity->name,
           'version' => $entity->version
      ]);
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $entity;
  }
  public function retrieve(ServiceRef $entity): ?Service {
    return $this->db->findOne('SELECT uid FROM service where uid = :uid',['uid' => $entity->uid], fn($row) => this->mapper($row));
  }
  public function update(Service $update): ?Service {
    $version = $update->version;
    $update->Version(0);
    try {
      $result = $this->db->execute('UPDATE service SET name = :name and version = :version WHERE uid = :uid and version = :version', [
           'uid' => $update->uid,
           'name' => $update->name,
           'version' => $update->version
      ]);
      if( !$result && $this->db->exists('select uid from service where uid = :uid', ['uid' => $update->uid ]) ) {
        throw new Error('Precondition fail ' . $this->uid);
      } else if(!$result) {
        throw new Error('Not found ' . $this->uid);
      }
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $update;
  }
  public function delete(ServiceRef $entity): bool {
    return $this->db->execute('DELETE FROM service where uid = :uid',['uid' => $entity->uid]);
  }
  public function exists(ServiceRef $entity, ?ServiceFilter $filter): bool {
    $sqlFilter = $this->filter($entity, $filter, null);
    return $this->db->exists($sqlFilter['query'], $sqlFilter['params']);
  }
  private function filter(?ServiceRef $ref,?ServiceFilter $filter,?ServiceSort $sort) {
    $join = '';
    $query = '';
    $params = [];
    if( $ref && $ref->uid ) {
      $query .= ' and uid = :uid';
      $params['uid'] = $ref->uid;
    }
    if( $filter ) {
      if( $filter->search) {
        $query .= ' and ( name like :search)';
        $params['search'] = '%' . filter->search . '%';
      }
    }
    return ['query' => 'SELECT * FROM service'
                          . ($join ? ' JOIN ' . substr($join, 6) : '')
                          . ($query ? ' WHERE ' . substr($query, 4) : ''),
                 'params' => $params];
  }
  private function checkDuplicates(Service $entity) {
    $values = ['uid' => $entity->uid];
    if( $this->pdo->exists('SELECT  uid from service where uid = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
    $values = ['name' => $entity->name];
    if( $this->pdo->exists('SELECT  name from service where name = :name and uid != :uid', $values) ) {
      throw new ConstraintException('not-unique', ['name' => $entity->name]);
    }
  }
  private function mapper($row): Service{
    return new Service(uid: $row['uid'],
          name: $row['name'],
          version: $row['version']);
  }
}


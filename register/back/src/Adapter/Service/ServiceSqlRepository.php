<?php
namespace Register\Adapter\Service;

use Closure;
use Civi\Micro\Sql\SqlTemplate;
use Civi\Micro\Sql\SqlParam;
use Register\Domain\Port\Spi\Service\ServiceRepository;
use Register\Domain\Model\Service;
use Register\Domain\Model\Query\ServiceFilter;
use Register\Domain\Model\Query\ServiceSort;
use Register\Domain\Model\Ref\ServiceRef;
use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
use Civi\Micro\Sql\NotUniqueException;
use Civi\Micro\Exception\ConstraintException;


class ServiceSqlRepository implements ServiceRepository {
  public function __construct(private readonly SqlTemplate $db) {}
  public function list(?ServiceFilter $filter, ?ServiceSort $sort): array {
    $sqlFilter = $this->filter(null, $filter, $sort);
    return $this->db->query($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row) );
  }
  public function create(Service $entity): Service {
    try {
      $this->db->execute('INSERT INTO service ( uid, name, enabled, version) VALUES ( :uid, :name, :enabled, :version)',[
           new SqlParam(name: 'uid', value: $entity->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $entity->name, type: SqlParam::STR),
           new SqlParam(name: 'enabled', value: $entity->enabled, type: SqlParam::BOOL),
           new SqlParam(name: 'version', value: 0, type: SqlParam::INT)
      ]);
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $entity->toBuilder()->version( 0 )->build();
  }
  public function retrieve(ServiceRef $ref, ?ServiceFilter $filter=null): ?Service {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->findOne($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row));
  }
  public function update(Service $update): ?Service {
    try {
      $result = $this->db->execute('UPDATE service SET name = :name , enabled = :enabled , version = :version WHERE uid = :uid and version = :_lock_version', [
           new SqlParam(name: 'uid', value: $update->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $update->name, type: SqlParam::STR),
           new SqlParam(name: 'enabled', value: $update->enabled, type: SqlParam::BOOL),
           new SqlParam(name: 'version', value: $update->version + 1, type: SqlParam::INT),
           new SqlParam(name: '_lock_version', value: $update->version, type: SqlParam::INT)
      ]);
      if( !$result && $this->db->exists('select uid from service where uid = :uid', ['uid' => $update->uid ]) ) {
        throw new OptimistLockException($update->uid, $update->version);
      } else if(!$result) {
        throw new NotFoundException($update->uid);
      }
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $update->toBuilder()->version( $update->version + 1 )->build();
  }
  public function delete(ServiceRef $ref): bool {
    return $this->db->execute('DELETE FROM service where uid = :uid',['uid' => $entity->uid]);
  }
  public function exists(ServiceRef $ref, ?ServiceFilter $filter=null): bool {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->exists($sqlFilter['query'], $sqlFilter['params']);
  }
  private function filter(?ServiceRef $ref,?ServiceFilter $filter,?ServiceSort $sort) {
    $join = '';
    $query = '';
    $params = [];
    if( $ref && $ref->uid ) {
      $query .= ' and uid = :uid';
      $params[] = new SqlParam( name: 'uid', value: $ref->uid, type: SqlParam::INT);
    }
    if( $filter ) {
      if( $filter->search) {
        $query .= ' and ( name like :search)';
        $params[] = new SqlParam(name:'search', value: '%'. $filter->search . '%', type: SqlType::STR);
      }
    }
    return ['query' => 'SELECT * FROM service'
                          . ($join ? ' JOIN ' . substr($join, 6) : '')
                          . ($query ? ' WHERE ' . substr($query, 4) : ''),
                 'params' => $params];
  }
  private function checkDuplicates(Service $entity) {
    $values = ['uid' => $entity->uid];
    if( $this->db->exists('SELECT  uid from service where uid = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
    $values = ['name' => $entity->name];
    if( $this->db->exists('SELECT  name from service where name = :name and uid != :uid', $values) ) {
      throw new ConstraintException('not-unique', ['name' => $entity->name]);
    }
  }
  private function mapper($row): Service{
    return Service::builder()->uid($row['uid'])
           ->name($row['name'])
           ->enabled($row['enabled'])
           ->version($row['version'])->build();
  }
}


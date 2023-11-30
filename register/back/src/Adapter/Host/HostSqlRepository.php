<?php
namespace Register\Adapter\Host;

use Closure;
use Civi\Micro\Sql\SqlTemplate;
use Register\Domain\Port\Spi\Host\HostRepository;
use Register\Domain\Model\Host;
use Register\Domain\Model\Query\HostFilter;
use Register\Domain\Model\Query\HostSort;
use Register\Domain\Model\Ref\HostRef;
use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
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
    try {
      $this->db->execute('INSERT INTO host ( uid, name, service, version) VALUES ( :uid, :name, :service, :version)',[
           'uid' => $entity->uid,
           'name' => $entity->name,
           'service' => $entity->service?->uid,
           'version' => 0
      ]);
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $entity->toBuilder()->version( 0 )->build();
  }
  public function retrieve(HostRef $entity): ?Host {
    return $this->db->findOne('SELECT * FROM host where uid = :uid',['uid' => $entity->uid], fn($row) => $this->mapper($row));
  }
  public function update(Host $update): ?Host {
    try {
      $result = $this->db->execute('UPDATE host SET name = :name , service = :service , version = :version WHERE uid = :uid and version = :_lock_version', [
           'uid' => $update->uid,
           'name' => $update->name,
           'service' => $update->service?->uid,
           'version' => $update->version + 1,
           '_lock_version' => $update->version
      ]);
      if( !$result && $this->db->exists('select uid from host where uid = :uid', ['uid' => $update->uid ]) ) {
        throw new OptimistLockException($update->uid, $update->version);
      } else if(!$result) {
        throw new NotFoundException($update->uid);
      }
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $update->toBuilder()->version( $update->version + 1 )->build();
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
    if( $this->db->exists('SELECT  uid from host where uid = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
    $values = ['name' => $entity->name];
    if( $this->db->exists('SELECT  name from host where name = :name and uid != :uid', $values) ) {
      throw new ConstraintException('not-unique', ['name' => $entity->name]);
    }
  }
  private function mapper($row): Host{
    return Host::builder()->uid($row['uid'])
           ->name($row['name'])
           ->service(new ServiceRef(uid: $row['service']))
           ->version($row['version'])->build();
  }
}


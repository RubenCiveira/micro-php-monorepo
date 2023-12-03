<?php
namespace Register\Adapter\Host;

use Civi\Micro\Exception\ConstraintException;
use Civi\Micro\Exception\NotFoundException;
use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Sql\NotUniqueException;
use Civi\Micro\Sql\SqlParam;
use Civi\Micro\Sql\SqlTemplate;
use Closure;
use Register\Domain\Model\Host;
use Register\Domain\Model\List\HostList;
use Register\Domain\Model\Query\HostFilter;
use Register\Domain\Model\Query\HostSort;
use Register\Domain\Model\Ref\HostRef;
use Register\Domain\Model\Ref\ServiceRef;
use Register\Domain\Port\Spi\Host\HostRepository;
class HostSqlRepository implements HostRepository {
  public function __construct(private readonly SqlTemplate $db) {}
  public function list(?HostFilter $filter, ?HostSort $sort): HostList {
    $sqlFilter = $this->filter(null, $filter, $sort);
    return new HostList( $this->db->query($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row) ) );
  }
  public function create(Host $entity): Host {
    try {
      $this->db->execute('INSERT INTO "host" ( "uid", "name", "service", "version") VALUES ( :uid, :name, :service, :version)',[
           new SqlParam(name: 'uid', value: $entity->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $entity->name, type: SqlParam::STR),
           new SqlParam(name: 'service', value: $entity->service?->uid, type: SqlParam::STR),
           new SqlParam(name: 'version', value: 0, type: SqlParam::INT)
      ]);
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $entity->toBuilder()->version( 0 )->build();
  }
  public function retrieve(HostRef $ref, ?HostFilter $filter=null): ?Host {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->findOne($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row));
  }
  public function update(Host $update): ?Host {
    try {
      $result = $this->db->execute('UPDATE "host" SET "name" = :name , "service" = :service , "version" = :version WHERE "uid" = :uid and "version" = :_lock_version', [
           new SqlParam(name: 'uid', value: $update->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $update->name, type: SqlParam::STR),
           new SqlParam(name: 'service', value: $update->service?->uid, type: SqlParam::INT),
           new SqlParam(name: 'version', value: $update->version + 1, type: SqlParam::INT),
           new SqlParam(name: '_lock_version', value: $update->version, type: SqlParam::INT)
      ]);
      if( !$result && $this->db->exists('select "uid" from "host" where "uid" = :uid', ['uid' => $update->uid ]) ) {
        throw new OptimistLockException($update->uid, $update->version);
      } else if(!$result) {
        throw new NotFoundException($update->uid);
      }
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $update->toBuilder()->version( $update->version + 1 )->build();
  }
  public function delete(HostRef $ref): bool {
    return $this->db->execute('DELETE FROM "host" where "uid" = :uid',[new SqlParam(name: 'uid', value: $ref->uid, type:SqlParam::INT)]);
  }
  public function exists(HostRef $ref, ?HostFilter $filter=null): bool {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->exists($sqlFilter['query'], $sqlFilter['params']);
  }
  private function filter(?HostRef $ref,?HostFilter $filter,?HostSort $sort) {
    $join = '';
    $query = '';
    $params = [];
    if( $ref && $ref->uid ) {
      $query .= ' and "uid" = :uid';
      $params[] = new SqlParam( name: 'uid', value: $ref->uid, type: SqlParam::INT);
    }
    if( $filter ) {
      if( $filter->service) {
        $query .= ' and "service" = :service';
        $params[] = new SqlParam(name: 'service', value: $filter->service, type: SqlParam::STR);
      }
    }
    return ['query' => 'SELECT * FROM "host"'
                          . ($join ? ' JOIN ' . substr($join, 6) : '')
                          . ($query ? ' WHERE ' . substr($query, 4) : ''),
                 'params' => $params];
  }
  private function checkDuplicates(Host $entity) {
    $values = ['uid' => $entity->uid];
    if( $this->db->exists('SELECT  "uid" from "host" where "uid" = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
    $values = ['name' => $entity->name, 'uid' => $entity->uid];
    if( $this->db->exists('SELECT  "name" from "host" where "name" = :name and "uid" != :uid', $values) ) {
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

